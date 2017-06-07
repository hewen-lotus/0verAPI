<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cerbero\CommandValidator\ValidatesInput;

use Carbon\Carbon;
use Excel;
use DB;
use Storage;

class PersonalAndPriorityDataImport extends Command
{
    use ValidatesInput;

    public function rules()
    {
        return [
            'apply_year' => 'integer',
            'identification' => 'string',
        ];
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data-import:personal-and-priority
                            {personal_file_path : 不知道是什麼的檔案}
                            {priority_file_path : 第二個不知道是什麼的檔案}
                            {apply_year : 應該是年度(int)} 
                            {identification : (*´･д･)? (string)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '產生匯入學生資料及志願序的 SQL query 的工具 ヽ(=^･ω･^=)丿';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $accept_mime = collect(['text/csv', 'text/plain']); //可接受的檔案 mime

        $personal_file_path = $this->argument('personal_file_path');

        $personal_file_mime = mime_content_type($personal_file_path);

        $priority_file_path = $this->argument('priority_file_path');

        $priority_file_mime = mime_content_type($priority_file_path);

        if (!$accept_mime->contains($personal_file_mime)) {
            $this->error('personal_file 檔案格式不符');
            return 0;
        }

        if (!$accept_mime->contains($priority_file_mime)) {
            $this->error('priority_file 檔案格式不符');
            return 0;
        }

        $apply_year = $this->argument('apply_year');

        $identification = $this->argument('identification');

        // 處理個人資料
        $personal_enctype = mb_detect_encoding(file_get_contents($personal_file_path), 'UTF-8, BIG-5', true);

        $personal_obj = Excel::load($personal_file_path, function($reader) {
            // Getting all results
        }, $personal_enctype)->get();

        $salt = "overseas";
        $query = '';

        $country_code = array(
            '阿富汗'=> '101', '巴林'=> '102', '孟加拉'=> '103', '不丹'=> '104',
            '英屬印度洋地區'=> '105', '緬甸'=> '106', '汶萊'=> '107', '柬埔寨'=> '108',
            '斯里蘭卡'=> '109', '外蒙古'=> '110', '可可斯群島'=> '111', '賽普勒斯'=> '112',
            '香港'=> '113', '印度'=> '114', '印尼'=> '115', '伊朗'=> '116', '伊拉克'=> '117',
            '以色列'=> '118', '日本'=> '119', '哈薩克'=> '120', '約旦'=> '121', '韓國'=> '123',
            '科威特'=> '124', '寮國'=> '125', '黎巴嫩'=> '126', '澳門'=> '127',
            '馬來西亞'=> '128', '馬爾地夫'=> '129', '蒙古'=> '130', '阿曼'=> '131',
            '尼泊爾'=> '132', '中立區'=> '133', '巴基斯坦'=> '134', '菲律賓'=> '135',
            '卡達'=> '136', '阿布達比'=> '137', '沙烏地阿拉伯'=> '138', '新加坡'=> '139',
            '越南'=> '140', '南葉門'=> '141', '敘利亞'=> '142', '泰國'=> '143',
            '阿拉伯聯合大公國'=> '144', '土耳其'=> '145', '葉門'=> '146', '臺灣'=> '147',
            '大陸'=> '148', '安地卡及巴布達'=> '201', '阿根廷'=> '202', '巴哈馬'=> '203',
            '巴貝多'=> '204', '百慕達'=> '205', '玻利維亞'=> '206', '巴西'=> '207',
            '貝里斯'=> '208', '英屬維爾京群島'=> '209', '加拿大'=> '210', '開曼群島'=> '211',
            '智利'=> '212', '哥倫比亞'=> '213', '哥斯大黎加'=> '214', '古巴'=> '215',
            '多米尼克'=> '216', '多明尼加'=> '217', '厄瓜多'=> '218', '薩爾瓦多'=> '219',
            '福克蘭群島'=> '220', '法屬圭亞那'=> '221', '格陵蘭'=> '222', '格瑞那達'=> '223',
            '瓜德魯普島'=> '224', '瓜地馬拉'=> '225', '蓋亞那'=> '226', '海地'=> '227',
            '赫德及麥當勞群島'=> '228', '宏都拉斯'=> '229', '牙買加'=> '230',
            '法屬馬丁尼克'=> '231', '墨西哥'=> '232', '荷屬安地列斯'=> '233', '阿魯巴'=> '234',
            '尼加拉瓜'=> '235', '巴拿馬'=> '236', '巴拉圭'=> '237', '秘魯'=> '238',
            '波多黎各'=> '239', '聖克里斯多福'=> '240', '聖露西亞'=> '241',
            '聖匹及密啟倫群島'=> '242', '聖文森'=> '243', '蘇利南'=> '244', '千里達'=> '245',
            '土克斯及開科斯群島'=> '246', '美國'=> '247', '美屬維爾京群島'=> '248',
            '烏拉圭'=> '249', '委內瑞拉'=> '250', '哥斯達黎加'=> '251', '阿爾及利亞'=> '301',
            '安哥拉'=> '302', '波札那'=> '303', '蒲隆地'=> '304', '喀麥隆'=> '305',
            '維德角島'=> '306', '中非'=> '307', '查德'=> '308', '葛摩'=> '309', '剛果'=> '310',
            '薩伊'=> '311', '貝南'=> '312', '赤道幾內亞'=> '313', '衣索比亞'=> '314',
            '法屬南部屬地'=> '315', '吉布地'=> '316', '加彭'=> '317', '甘比亞'=> '318',
            '迦納'=> '319', '幾內亞'=> '320', '象牙海岸'=> '321', '肯亞'=> '322',
            '賴索托'=> '323', '賴比瑞亞'=> '324', '利比亞'=> '325', '馬達加斯加'=> '326',
            '馬拉威'=> '327', '馬利'=> '328', '茅利塔尼亞'=> '329', '模里西斯'=> '330',
            '斯洛維尼亞'=> '331', '摩洛哥'=> '332', '莫三比克'=> '333', '納米比亞'=> '334',
            '尼日'=> '335', '奈及利亞'=> '336', '尼日'=> '337', '奈及利亞'=> '338',
            '幾內亞比索'=> '339', '留尼旺'=> '340', '盧安達'=> '341', '聖赫勒拿島'=> '342',
            '聖多美及普林西比'=> '343', '塞內加爾'=> '344', '塞席爾'=> '345', '獅子山'=> '346',
            '索馬利亞'=> '347', '南非'=> '348', '辛巴威'=> '349', '西撒哈拉'=> '350',
            '蘇丹'=> '351', '史瓦濟蘭'=> '352', '多哥'=> '353', '突尼西亞'=> '354',
            '烏干達'=> '355', '坦尚尼亞'=> '356', '布吉納法索'=> '357', '尚比亞'=> '358',
            '安道爾'=> '401', '奧地利'=> '402', '比利時'=> '403', '保加利亞'=> '404',
            '斯洛伐克'=> '405', '白俄羅斯'=> '406', '捷克'=> '407', '丹麥'=> '408',
            '法羅群島'=> '409', '芬蘭'=> '410', '法國'=> '411', '德國'=> '412',
            '東德'=> '413', '西德'=> '414', '直布羅陀'=> '415', '希臘'=> '416',
            '教廷'=> '417', '匈牙利'=> '418', '冰島'=> '419', '愛爾蘭'=> '420',
            '義大利'=> '421', '拉脫維雅'=> '422', '列支敦斯堡'=> '424', '盧森堡'=> '425',
            '馬爾他'=> '426', '摩納哥'=> '427', '蒙瑟拉特'=> '428', '荷蘭'=> '429',
            '挪威'=> '430', '波蘭'=> '431', '葡萄牙'=> '432', '羅馬尼亞'=> '433',
            '俄羅斯'=> '434', '吉爾吉斯'=> '435', '拉脫維亞'=> '436', '英屬安圭拉'=> '437',
            '英屬澤西島'=> '438', '聖馬利諾'=> '439', '西班牙'=> '440', '斯瓦巴及尖棉島'=> '441',
            '瑞典'=> '442', '瑞士'=> '443', '烏克蘭'=> '444', '蘇聯'=> '445', '埃及'=> '446',
            '英國'=> '447', '南斯拉夫'=> '448', '歐洲'=> '449', '立陶宛'=> '450',
            '克羅埃西亞'=> '451', '烏茲別克'=> '452', '馬其頓'=> '453', '南極洲'=> '501',
            '美屬薩摩亞'=> '502', '澳大利亞'=> '503', '波維特島'=> '504', '索羅門群島'=> '505',
            '聖誕島'=> '506', '科克群島'=> '507', '斐濟群島'=> '508', '法屬玻里尼西亞'=> '509',
            '吉里巴斯'=> '510', '關島'=> '511', '新喀里多尼亞島'=> '512', '萬那杜'=> '513',
            '紐西蘭'=> '514', '紐威島'=> '515', '諾福克群島'=> '516', '北馬里亞納群島'=> '517',
            '美屬邊疆群島'=> '518', '密克羅尼西亞'=> '519', '馬紹爾群島'=> '520',
            '帛琉群島'=> '521', '巴布亞紐幾內亞'=> '522', '皮特康島'=> '523', '帝汶'=> '524',
            '托克勞群島'=> '525', '東加'=> '526', '吐瓦魯'=> '527', '沃里斯與伏塔那島'=> '528',
            '薩摩亞群島'=> '529'
        );

        $index = array(
            '報名序號' => 'idcode',
            '僑生編號' => 'id',
            '中文姓名' => 'name',
            '姓名' => 'name',
            '英文姓名' => 'ename',
            '性別' => 'sex',
            '出生日期' => 'birthday',
            '生日' => 'birthday',
            'applyway' => 'applyWay',
            '類組' => 'groupcode',
            '出生地' => 'birthPlace',
            '籍貫' => 'nativeProvince',
            '僑居地' => 'country',
            '僑居地址' => 'address',
            '僑居地地址' => 'address',
            '僑居地最高學歷校名' => 'lastSchool',
            '僑生聯絡電話' => 'handphone',
            '僑居地電話' => 'handphone',
            '外國護照號碼' => 'passport',
            '僑居地護照' => 'passport',
            '外國身份證號' => 'idNo',
            '僑居地身份證' => 'idNo',
            '僑居地身分證' => 'idNo',
            '中華民國護照號碼' => 'taiwanPassport',
            '台灣護照' => 'taiwanPassport',
            '中華民國身份證號' => 'taiwanIdCode',
            '台灣身份證' => 'taiwanIdCode',
            '台灣身分證' => 'taiwanIdCode',
            '父親中文姓名' => 'fatherChineseName',
            '父親中文名字' => 'fatherChineseName',
            '父親英文姓名' => 'fatherEnglishName',
            '父親英文名字' => 'fatherEnglishName',
            '父親出生日期' => 'fab',
            '父親生日' => 'fab',
            '母親中文姓名' => 'motherChineseName',
            '母親中文名字' => 'motherChineseName',
            '母親英文姓名' => 'motherEnglishName',
            '母親英文名字' => 'motherEnglishName',
            '母親出生日期' => 'mab',
            '母親生日' => 'mab',
            '在台監護聯絡人姓名' => 'contactName',
            '在台監護人姓名' => 'contactName',
            '在台聯絡人姓名' => 'contactName',
            '在台聯絡人' => 'contactName',
            '電話' => 'contactPhone',
            '在台聯絡電話' => 'contactPhone',
            '地址' => 'contactAddress',
            '在台聯絡地址' => 'contactAddress',
            '保薦單位' => 'degree',
            '保送單位' => 'degree'
        );

        $id_to_idcode = array();
        // $array;
        // array_add($array, 'key', $value);


        foreach ($personal_obj as $row) {
            $keys = '';
            $values = '';
            $id_to_idcode = array_add($id_to_idcode, (string)$row['僑生編號'], (string)$row['報名序號']);

            foreach ($row as $key => $value) {
                $col_name = array_get($index, $key, '-1');
                if ($col_name != '-1') {
                    switch ($col_name) {

                        case 'groupcode':
                            if ($value !== '1' || $value !== '2' || $value !== '3') {
                                $col_value = substr((string)$row['僑生編號'], 0, 1);
                            } else {
                                $col_value = $value;
                            }
                            break;

                        case 'sex':
                            if ($value == '男') {
                                $col_value = 'M';
                            } else {
                                $col_value = 'F';
                            }
                            break;

                        case 'birthPlace':
                        case 'country':
                        case 'lastSchoolCountry':
                            if ($value == '') {
                                $col_value = '000';
                            } else {
                                $col_value = array_get($country_code, $value);
                            }
                            break;

                        case 'birthday':
                        case 'address':
                        case 'phone':
                        case 'handphone':
                        case 'taiwanAddress':
                        case 'taiwanPhone':
                        case 'taiwanIdCode':
                        case 'passport':
                        case 'lastSchool':
                        case 'nativeProvince':
                        case 'fatherChineseName':
                        case 'fatherEnglishName':
                        case 'motherChineseName':
                        case 'motherEnglishName':
                        case 'contactName':
                        case 'contactAddress':
                        case 'contactPhone':
                        case 'taiwanPassport':
                        case 'degree':
                        case 'contactRelation':
                        case 'contactServiceName':
                        case 'contactServicePhone':
                        case 'lastEnterTime':
                        case 'lastGraTime':
                        case 'moveTime':
                        case 'moveFrom':
                        case 'idNo':
                        case 'fab':
                        case 'fap':
                        case 'fao':
                        case 'mab':
                        case 'map':
                        case 'mao':
                        case 'disabilityExplain':
                        case 'disabilityExplain2':
                        case 'disabilityLevel':
                        case 'province':
                            $col_value = 'aes_encrypt("'.$value.'", "'.$salt.'")';
                            break;
                        default:
                            $col_value = $value;
                            break;
                    }

                    if ($keys == '') {
                        $keys = $col_name;
                    } else {
                        $keys .= ','.$col_name;
                    }

                    if ($values == '') {
                        if (explode('(', $col_value)[0] == 'aes_encrypt') {
                            $values = $col_value;
                        } else {
                            $values = '"'.$col_value.'"';
                        }
                    } else {
                        if (explode('(', $col_value)[0] == 'aes_encrypt') {
                            $values .= ','.$col_value;
                        } else {
                            $values .= ',"'.$col_value.'"';
                        }
                    }
                } else {
                    $this->info($key);
                }
            }

            if (!array_has($row, '類組')) {
                $keys.= ',groupcode';
                $values .= ',"'.substr((string)$row['僑生編號'], 0, 1).'"';
            }

            $keys .= ',account';
            $values .= ',"'.$row['僑生編號'].$row['報名序號'].'"';

            $keys .= ',password';
            $values .= ',"'.substr(bcrypt($row['僑生編號'].$row['報名序號']), 0, 40).'"';

            $keys .= ',memo2';
            $values .= ',""';

            $keys .= ',holdpassportP_date';
            $values .= ',"0000-00-00"';

            $keys .= ',rtime';
            $values .= ',"'.date('Y-m-d H:i:s').'"';

            $keys .= ',applyyear';
            $values .= ',"' . $apply_year . '"';

            $keys .= ',updateCheck';
            $values .= ',"N"';

            $keys .= ',getORnot';
            $values .= ',"A"';

            $keys .= ',identification';
            $values .= ',"' . $identification . '"';

            // 緬甸同學電子檔案沒有最後畢業中學國別，
            // 不過緬甸同學僅能使用當地文憑，
            // 故固定為緬甸國碼 106 即可
            if (substr((string)$row['僑生編號'], 1, 2) == '16'
                || substr((string)$row['僑生編號'], 1, 2) == '17'
                || substr((string)$row['僑生編號'], 1, 2) == '18'
                || substr((string)$row['僑生編號'], 1, 2) == '19') {

                $keys .= ',lastSchoolCountry';
                $values .= ',"106"';
            }

            // array_push($query_applicant, 'insert into applicant('.$keys.') values('.$values.');');
            $query .= 'insert into applicant('.$keys.') values('.$values.');'.PHP_EOL;
        }

        // 處理讀卡志願
        $enctype = mb_detect_encoding(file_get_contents($priority_file_path), 'UTF-8, BIG-5', true);

        $priority_obj = Excel::load($priority_file_path, function($reader) {
            // Getting all results
        }, $enctype)->get();

        $priorities = 70; // 可填的志願數

        $error_less_than_four = '';
        $error_dept_not_found = '';
        $error_id_not_found = '';
        $error_group_not_match = '';

        foreach ($priority_obj as $row1) {
            if (array_has($row1, '准考證號')) {
                $id = $row1['准考證號'];
            } else if (array_has($row1, '僑生編號')) {
                $id = $row1['僑生編號'];
            }
            if ( array_has($id_to_idcode, (string)$id) ) {
                $idcode = array_get($id_to_idcode, (string)$id);
                for ($j = 0; $j < $priorities; $j++) {
                    $oldcode = trim($row1['s'.($j + 1)]);

                    if (!empty($oldcode)) {
                        if (strlen($oldcode) < 4) {
                            $error_less_than_four .=
                                '#'.$id.'亂畫卡RRRRRRR QAQ （讀卡機無法判讀）, 志願序: '.($j + 1).' 讀卡結果: '.$oldcode.PHP_EOL;
                        } else if (!DB::table('depart')->where('oldcode', $oldcode)->exists()) {
                            $error_dept_not_found .=
                                '#'.$id.'不想唸RRRRRRR QAQ （畫的志願不存在）, 志願序: '.($j + 1).' 讀卡結果: '.$oldcode.PHP_EOL;
                        } else if ((substr($id, 0, 1) == '1' && substr($oldcode, 0, 1) % 3 != '1') // 一類跨二三類
                            || (substr($id, 0, 1) == '2' && substr($oldcode, 0, 1) % 3 == '1') // 二類跨一類
                            || (substr($id, 0, 1) == '3' && substr($oldcode, 0, 1) % 3 == '1')) { // 三類跨一類
                            $error_group_not_match .=
                                '#'.$id.'劈腿啦RRRRRRR QAQ （跨文理組）, 志願序: '.($j + 1).' 讀卡結果: '.$oldcode.' 類組: '.substr($id, 0, 1).PHP_EOL;
                        } else {
                            $query .= 'insert into selection(idcode,oldcode,ser) values("'.$idcode.'","'.$oldcode.'","'.str_pad($j + 1, 2, '0', STR_PAD_LEFT).'");'.PHP_EOL;
                        }
                    }
                }
            } else {
                $error_id_not_found .=
                    '#'.$id.'找不到RRRRRRR QAQ （讀卡機無法判讀）, 僑生編號: '.$id.PHP_EOL;
            }
        }

        $result_data = $error_less_than_four.PHP_EOL.$error_dept_not_found
            .PHP_EOL.$error_id_not_found.PHP_EOL.$error_group_not_match
            .PHP_EOL.$query;

        $time = Carbon::now();

        Storage::disk('artisan')->put('personal-and-priority-data/'.$time, $result_data);

        $this->info('All Done! Your file is at '.storage_path('app/artisan/personal-and-priority-data/'.$time));
    }
}
