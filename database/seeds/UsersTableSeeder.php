<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = Carbon::now();

        if (!App::environment('production')) {
            DB::table('users')->insert([
                [
                    'username' => 'admin1',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'a@a.a',
                    'name' => '管理者一號',
                    'eng_name' => 'admin1',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'admin2',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'b@a.a',
                    'name' => '管理者二號',
                    'eng_name' => 'admin2',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'admin3',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'a@b.a',
                    'name' => '管理者三號',
                    'eng_name' => 'admin2',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'editor1',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'a@a.a',
                    'name' => 'A編輯',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'editor2',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'b@a.a',
                    'name' => 'B編輯',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'editor3',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'c@a.a',
                    'name' => 'C編輯',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'reviewer1',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'z@a.a',
                    'name' => '審核一號',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'reviewer2',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'x@a.a',
                    'name' => '審核二號',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'reviewer3',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'c@b.a',
                    'name' => '審核三號',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ]
            ]);
        }

        $schools = [ // z%z -> @
            ['name' => '國立臺灣大學','eng_name' => 'National  Taiwan University','phone' => '886-2-33662388轉203','username' => 'ntu','email' => 'ntuz%zntu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立成功大學','eng_name' => 'National Cheng Kung University','phone' => '886-6-2757575','username' => 'ncku','email' => 'nckuz%zncku.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立嘉義大學','eng_name' => 'National Chiayi University','phone' => '886-5-2717296','username' => 'ncyu','email' => 'ncyuz%zncyu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立暨南國際大學','eng_name' => 'National Chi Nan University','phone' => '886-49-2918305','username' => 'ncnu','email' => 'ncnuz%zncnu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立中興大學','eng_name' => 'National Chung Hsing University','phone' => '886-4-22873181','username' => 'nchu','email' => 'nchuz%znchu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立中正大學','eng_name' => 'National Chung Cheng University','phone' => '886-5-2720411','username' => 'ccu','email' => 'ccuz%zccu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺灣師範大學','eng_name' => 'National Taiwan Normal University','phone' => '886-2-7734-3076','username' => 'ntnu','email' => 'ntnuz%zntnu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立東華大學','eng_name' => 'National Dong Hwa University','phone' => '886-3-863-4113','username' => 'ndhu','email' => 'ndhuz%zndhu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺灣海洋大學','eng_name' => 'National Taiwan Ocean University','phone' => '886-2-24622192','username' => 'ntou','email' => 'ntouz%zntou.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺北大學','eng_name' => 'National Taipei University','phone' => '886-2-86741111#66122','username' => 'ntpu','email' => 'ntpuz%zntpu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立交通大學','eng_name' => 'National Chiao Tung University','phone' => '886-3-5131399','username' => 'nctu','email' => 'nctuz%znctu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立高雄大學','eng_name' => 'National University of Kaohsiung','phone' => '886-7-5919000#8240~8243','username' => 'nuk','email' => 'nukz%znuk.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立政治大學','eng_name' => 'National Chengchi University','phone' => '886-2-29387892','username' => 'nccu','email' => 'nccuz%znccu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立宜蘭大學','eng_name' => 'National Ilan University','phone' => '886-3-9357400','username' => 'niu','email' => 'niuz%zniu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立中央大學','eng_name' => 'National Central University','phone' => '886-3-4227151轉57141','username' => 'ncu','email' => 'ncuz%zncu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立聯合大學','eng_name' => 'National United University','phone' => '886-37-381000','username' => 'nuu','email' => 'nuuz%znuu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立清華大學','eng_name' => 'National Tsing Hua University','phone' => '886-3-5712861','username' => 'nthu','email' => 'nthuz%znthu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺南大學','eng_name' => 'National University of Tainan','phone' => '886-6-2133111','username' => 'nutn','email' => 'nutnz%znutn.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立中山大學','eng_name' => 'National Sun Yat-sen University','phone' => '886-7-5252000','username' => 'nsysu','email' => 'nsysuz%znsysu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺東大學','eng_name' => 'National Taitung University','phone' => '886-89-517334','username' => 'nttu','email' => 'nttuz%znttu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立陽明大學','eng_name' => 'National Yang-Ming University','phone' => '886-2-28267000 #2299,2268','username' => 'ym','email' => 'ymz%zym.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國防醫學院','eng_name' => 'National Defense Medical Center','phone' => '886-2-87926692','username' => 'ndmctsgh','email' => 'ndmctsghz%zndmctsgh.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立彰化師範大學','eng_name' => 'National Changhua University of Education','phone' => '886-4-7232105','username' => 'ncue','email' => 'ncuez%zncue.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立屏東教育大學','eng_name' => 'National Pingtung University of Education','phone' => '886-8-7226141','username' => 'npue','email' => 'npuez%znpue.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '臺北市立教育大學','eng_name' => 'Taipei Municipal University of Education','phone' => '886-2-23113040','username' => 'tmue','email' => 'tmuez%ztmue.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺中教育大學','eng_name' => 'National Taichung University of Education','phone' => '886-4-22183456','username' => 'ntcu','email' => 'ntcuz%zntcu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立高雄師範大學','eng_name' => 'National Kaohsiung Normal University','phone' => '886-7-7172930','username' => 'nknu','email' => 'nknuz%znknu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺北教育大學','eng_name' => 'National Taipei University of Education','phone' => '886-2-27321104轉82226','username' => 'ntue','email' => 'ntuez%zntue.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立新竹教育大學','eng_name' => 'National Hsinchu University of Education','phone' => '886-3-5213132','username' => 'nhcue','email' => 'nhcuez%znhcue.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺灣體育運動大學','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','username' => 'ntupes','email' => 'ntupesz%zntupes.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '臺北市立體育學院','eng_name' => 'Taipei Physical Education College','phone' => '886-2-28718288','username' => 'tpec','email' => 'tpecz%ztpec.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立體育大學','eng_name' => 'National Taiwan Sport University','phone' => '886-3-3283201','username' => 'ntsu','email' => 'ntsuz%zntsu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺北藝術大學','eng_name' => 'Taipei National University of the Arts','phone' => '+886-2-28961000','username' => 'tnua','email' => 'tnuaz%ztnua.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺灣藝術大學','eng_name' => 'National Taiwan University of Arts','phone' => '886-2-22722181  #1152','username' => 'ntua','email' => 'ntuaz%zntua.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺南藝術大學','eng_name' => 'Tainan National University of the Arts','phone' => '886-6-6930100 #1212','username' => 'tnnua','email' => 'tnnuaz%ztnnua.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中國文化大學','eng_name' => 'Chinese Culture University','phone' => '886-2-28610511  #11307','username' => 'pccu','email' => 'pccuz%zpccu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '淡江大學','eng_name' => 'Tamkang University','phone' => '886-2-26215656','username' => 'tku','email' => 'tkuz%ztku.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '銘傳大學','eng_name' => 'Ming Chuan University','phone' => '886-2-28824564','username' => 'mcu','email' => 'mcuz%zmcu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '東海大學','eng_name' => 'Tunghai University','phone' => '886-4-23598900','username' => 'thu','email' => 'thuz%zthu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '實踐大學','eng_name' => 'Shih Chien University','phone' => '886-2-25381111','username' => 'usc','email' => 'uscz%zusc.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '義守大學','eng_name' => 'I-Shou University','phone' => '886-7-6577711','username' => 'isu','email' => 'isuz%zisu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '靜宜大學','eng_name' => 'Providence University','phone' => '886-4-26328001','username' => 'pu','email' => 'puz%zpu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '真理大學','eng_name' => 'Aletheia University','phone' => '886-2-26290228','username' => 'au','email' => 'auz%zau.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '逢甲大學','eng_name' => 'Feng Chia University','phone' => '886-4-24517250轉2184','username' => 'fcu','email' => 'fcuz%zfcu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '輔仁大學','eng_name' => 'Fu Jen Catholic University','phone' => '886-2-29053142','username' => 'fju','email' => 'fjuz%zfju.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '長榮大學','eng_name' => 'Chang Jung Christian University','phone' => '886-6-2785123','username' => 'cjcu','email' => 'cjcuz%zcjcu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '亞洲大學','eng_name' => 'Asia University','phone' => '886-4-23323456 轉 6276','username' => 'asia','email' => 'asiaz%zasia.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '世新大學','eng_name' => 'Shih Hsin University','phone' => '886-2-22368225','username' => 'shu','email' => 'shuz%zshu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '大葉大學','eng_name' => 'Dayeh University','phone' => '886-4-8511888','username' => 'dyu','email' => 'dyuz%zdyu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中華大學','eng_name' => 'Chung Hua University','phone' => '886-3-5186221','username' => 'chu','email' => 'chuz%zchu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '台灣首府大學','eng_name' => 'Taiwan Shoufu University','phone' => '886-6-5718818','username' => 'tsu','email' => 'tsuz%ztsu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '康寧大學','eng_name' => 'University of Kang Ning','phone' => '886-6-2552500','username' => 'ukn','email' => 'uknz%zukn.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中信金融管理學院','eng_name' => 'CTBC Financial Management College','phone' => '886-6-2873337','username' => 'ctbc','email' => 'ctbcz%zctbc.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '明道大學','eng_name' => 'MingDao University','phone' => '886-4-8876660','username' => 'mdu','email' => 'mduz%zmdu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '東吳大學','eng_name' => 'Soochow University','phone' => '886-2-28819471','username' => 'scu','email' => 'scuz%zscu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '開南大學','eng_name' => 'Kainan University','phone' => '886-3-3412500分機1335','username' => 'knu','email' => 'knuz%zknu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '元智大學','eng_name' => 'Yuan Ze University','phone' => '886-3-4638800-2252','username' => 'yzu','email' => 'yzuz%zyzu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '稻江科技暨管理學院','eng_name' => 'Toko University','phone' => '886-5-3622889','username' => 'toko','email' => 'tokoz%ztoko.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '玄奘大學','eng_name' => 'Hsuan Chuang University','phone' => '886-3-5302255 *2144','username' => 'hcu','email' => 'hcuz%zhcu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '南華大學','eng_name' => 'Nanhua University','phone' => '886-5-2721001分機1723','username' => 'nhu','email' => 'nhuz%znhu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中原大學','eng_name' => 'Chung Yuan Christian University','phone' => '886-3-2651718','username' => 'cycu','email' => 'cycuz%zcycu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '華梵大學','eng_name' => 'Huafan University','phone' => '886-2-26632102#2231','username' => 'hfu','email' => 'hfuz%zhfu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '大同大學','eng_name' => 'Tatung University','phone' => '886-2-21822928#6054','username' => 'ttu','email' => 'ttuz%zttu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '佛光大學','eng_name' => 'Fo Guang University','phone' => '886-3-9871000','username' => 'fgu','email' => 'fguz%zfgu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '長庚大學','eng_name' => 'Chang Gung University','phone' => '886-3-2118800','username' => 'cgu','email' => 'cguz%zcgu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中山醫學大學','eng_name' => 'Chung Shan Medical University','phone' => '886-4-24730022','username' => 'csmu','email' => 'csmuz%zcsmu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '高雄醫學大學','eng_name' => 'Kaohsiung Medical University','phone' => '886-7-3121101#2109','username' => 'kmu','email' => 'kmuz%zkmu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中國醫藥大學','eng_name' => 'China Medical University','phone' => '886-4-22070165','username' => 'cmu','email' => 'cmuz%zcmu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '臺北醫學大學','eng_name' => 'Taipei Medical University','phone' => '886-2-27361661','username' => 'tmu','email' => 'tmuz%ztmu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '慈濟大學','eng_name' => 'Tzu Chi University','phone' => '886-3-8565301','username' => 'tcu','email' => 'tcuz%ztcu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺灣科技大學','eng_name' => 'National Taiwan University of Science and Technology','phone' => '886-2-27301190','username' => 'ntust','email' => 'ntustz%zntust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立雲林科技大學','eng_name' => 'National Yunlin University of Science and Technology','phone' => '886-5-5372637','username' => 'yuntech','email' => 'yuntechz%zyuntech.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺北科技大學','eng_name' => 'National Taipei University of Technology','phone' => '886-2-27712171','username' => 'ntut','email' => 'ntutz%zntut.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立屏東科技大學','eng_name' => 'National Pingtung University of Science and Technology','phone' => '886-8-7703202','username' => 'npust','email' => 'npustz%znpust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立高雄第一科技大學','eng_name' => 'National Kaohsiung First University of Science and Technology','phone' => '886-7-6011000  #1621','username' => 'nkfust','email' => 'nkfustz%znkfust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立高雄應用科技大學','eng_name' => 'NATIONAL KAOHSIUNG UNIVERSITY OF APPLIED SCIENCES','phone' => '886-7-3814526分機2311','username' => 'kuas','email' => 'kuasz%zkuas.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立高雄海洋科技大學','eng_name' => 'National Kaohsiung Marine University','phone' => '886-7-3617141','username' => 'nkmu','email' => 'nkmuz%znkmu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立虎尾科技大學','eng_name' => 'National Formosa University','phone' => '886-5-6315108','username' => 'nfu','email' => 'nfuz%znfu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立屏東商業技術學院','eng_name' => 'National Pingtung Institute of Commerce','phone' => '886-8-7238700','username' => 'npic','email' => 'npicz%znpic.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立金門大學','eng_name' => 'National Quemoy University','phone' => '886-82-313734','username' => 'nqu','email' => 'nquz%znqu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立勤益科技大學','eng_name' => 'National Chin-Yi University of Technology','phone' => '886-4-23924505','username' => 'ncut','email' => 'ncutz%zncut.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺中科技大學','eng_name' => 'National Taichung University of Science and Technology','phone' => '886-4-22195762','username' => 'nutc','email' => 'nutcz%znutc.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立高雄餐旅大學','eng_name' => 'National Kaohsiung University of Hospitality and Tourism','phone' => '886-7-8060505','username' => 'nkuht','email' => 'nkuhtz%znkuht.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺北商業大學','eng_name' => 'National Taipei University of Business','phone' => '886-2-23226050','username' => 'ntub','email' => 'ntubz%zntub.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺北護理健康大學','eng_name' => 'National Taipei University of Nursing and Health Science','phone' => '02-28227101ext.2731','username' => 'ntunhs','email' => 'ntunhsz%zntunhs.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '朝陽科技大學','eng_name' => 'Chaoyang University of Technology','phone' => '886-4-23331637','username' => 'cyut','email' => 'cyutz%zcyut.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '南臺科技大學','eng_name' => 'Southern Taiwan University of Science and Technology','phone' => '886-6-2533131','username' => 'stust','email' => 'stustz%zstust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '崑山科技大學','eng_name' => 'Kun Shan University','phone' => '886-6-2727175  #221','username' => 'ksu','email' => 'ksuz%zksu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '樹德科技大學','eng_name' => 'Shu-Te University','phone' => '886-7-6158000','username' => 'stu','email' => 'stuz%zstu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '嘉藥學校財團法人嘉南藥理大學','eng_name' => 'Chia Nan University of Pharmacy and Science','phone' => '886-6-2664911','username' => 'cnu','email' => 'cnuz%zcnu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '明新科技大學','eng_name' => 'Minghsin University of Science and Technology','phone' => '886-3-5593142#2145','username' => 'must','email' => 'mustz%zmust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '輔英科技大學','eng_name' => 'Fooyin University','phone' => '886-7-7811151','username' => 'fy','email' => 'fyz%zfy.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '弘光科技大學','eng_name' => 'HungKuang University','phone' => '886-4-26318652','username' => 'hk','email' => 'hkz%zhk.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '正修科技大學','eng_name' => 'Cheng Shiu University','phone' => '886-7-7358800','username' => 'csu','email' => 'csuz%zcsu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '健行科技大學','eng_name' => 'Chien Hsin University of Science and Technology','phone' => '886-3-4581196','username' => 'uch','email' => 'uchz%zuch.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '萬能學校財團法人萬能科技大學','eng_name' => 'Vanung University','phone' => '886-3-4515811','username' => 'vnu','email' => 'vnuz%zvnu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '明志科技大學','eng_name' => 'MING CHI UNIVERSITY OF TECHNOLOGY','phone' => '886-2-29089899','username' => 'mcut','email' => 'mcutz%zmcut.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中國科技大學','eng_name' => 'China University of Technology','phone' => '886-2-29313416','username' => 'cute','email' => 'cutez%zcute.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '大仁科技大學','eng_name' => 'Tajen University ','phone' => '886-8-7626903','username' => 'tajen','email' => 'tajenz%ztajen.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '高苑科技大學','eng_name' => 'KAO YUAN UNIVERSITY','phone' => '886-7-6077914','username' => 'kyu','email' => 'kyuz%zkyu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '嶺東科技大學','eng_name' => 'Ling Tung University','phone' => '886-4-23892088','username' => 'ltu','email' => 'ltuz%zltu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '聖約翰科技大學','eng_name' => 'St. John\'s University','phone' => '886-2-28013131#6885','username' => 'sju','email' => 'sjuz%zsju.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中臺科技大學','eng_name' => 'Central Taiwan University of Science and Technology','phone' => '886-4-22391647','username' => 'ctust','email' => 'ctustz%zctust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '台南家專學校財團法人台南應用科技大學','eng_name' => 'Tainan University of Technology','phone' => '886-6-2535643','username' => 'tut','email' => 'tutz%ztut.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '遠東科技大學','eng_name' => 'Far East University','phone' => '886-6-5979566','username' => 'feu','email' => 'feuz%zfeu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '光宇學校財團法人元培醫事科技大學','eng_name' => 'Yuanpei University of Medical Technology','phone' => '886-3-6102215','username' => 'ypu','email' => 'ypuz%zypu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中州學校財團法人中州科技大學','eng_name' => 'Chung Chou University of Science and Technology','phone' => '886-4-835-9000','username' => 'ccut','email' => 'ccutz%zccut.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '南開科技大學','eng_name' => 'Nan Kai University of Technology','phone' => '886-49-2563489','username' => 'nkut','email' => 'nkutz%znkut.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中華學校財團法人中華科技大學','eng_name' => 'China University of Science and Technology','phone' => '886-2-27821862','username' => 'cust','email' => 'custz%zcust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '大華學校財團法人大華科技大學','eng_name' => 'Ta Hwa University','phone' => '886-3-592-7700','username' => 'tust','email' => 'tustz%ztust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '大漢技術學院','eng_name' => 'Dahan Institute of Technology','phone' => '886-3-8210-888轉1820','username' => 'dahan','email' => 'dahanz%zdahan.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '文藻外語大學','eng_name' => 'Wenzao Ursuline University of Languages','phone' => '886-7-3426031#2643','username' => 'wzu','email' => 'wzuz%zwzu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '景文科技大學','eng_name' => 'Jinwen University of Science and Technology','phone' => '886-2-82122000','username' => 'just','email' => 'justz%zjust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '慈濟學校財團法人慈濟科技大學','eng_name' => 'Tzu Chi University of Science and Technology','phone' => '886-3-8572158','username' => 'tcust','email' => 'tcustz%ztcust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '永達技術學院','eng_name' => 'Yung Ta Institute of Technology & Commerce','phone' => '886-8-7233733','username' => 'ytit','email' => 'ytitz%zytit.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '和春技術學院','eng_name' => 'Fortune Institute of Technology','phone' => '886-7-7889888','username' => 'fotech','email' => 'fotechz%zfotech.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '亞東技術學院','eng_name' => 'Oriental Institute of Technology','phone' => '886-2-77387708','username' => 'oit','email' => 'oitz%zoit.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '城市學校財團法人臺北城市科技大學','eng_name' => 'Taipei Chengshih University of Science and Technology','phone' => '886-2-28927154','username' => 'tpcu','email' => 'tpcuz%ztpcu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '南亞科技學校財團法人南亞技術學院','eng_name' => 'Nanya Institute of Technology','phone' => '886-3-4361070','username' => 'nanya','email' => 'nanyaz%znanya.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '吳鳳學校財團法人吳鳳科技大學','eng_name' => 'WuFeng University','phone' => '886-5-2269954','username' => 'wfu','email' => 'wfuz%zwfu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '東南科技大學','eng_name' => 'Tungnan University','phone' => '+886-2-86625948','username' => 'tnu','email' => 'tnuz%ztnu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '僑光科技大學','eng_name' => 'Overseas Chinese University','phone' => '886-4-27016855','username' => 'ocu','email' => 'ocuz%zocu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '致理科技大學','eng_name' => 'Chihlee University of Technology','phone' => '886-2-22580500','username' => 'chihlee','email' => 'chihleez%zchihlee.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '醒吾科技大學','eng_name' => 'Hsing Wu University of Science and Technology','phone' => '886-2-26015310#1201','username' => 'hwu','email' => 'hwuz%zhwu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '德明財經科技大學','eng_name' => 'Takming University of Science and Technology','phone' => '886-2-77290799','username' => 'takming','email' => 'takmingz%ztakming.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '環球學校財團法人環球科技大學','eng_name' => 'TransWorld University','phone' => '886-5-5370988 # 2230~2236','username' => 'twu','email' => 'twuz%ztwu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '美和學校財團法人美和科技大學','eng_name' => 'Meiho University','phone' => '886-8-7799821 #8144','username' => 'meiho','email' => 'meihoz%zmeiho.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '德霖技術學院','eng_name' => 'De Lin Institute of Technology','phone' => '886-2-22733567 轉 688-693','username' => 'dlit','email' => 'dlitz%zdlit.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '南榮學校財團法人南榮科技大學','eng_name' => 'Nan Jeon University of Science and Technology','phone' => '886-6-652-3111#1903','username' => 'nju','email' => 'njuz%znju.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '東方學校財團法人東方設計學院','eng_name' => 'TUNGFANG DESIGN INSTITUTE','phone' => '886-7-6939583','username' => 'tf','email' => 'tfz%ztf.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '修平學校財團法人修平科技大學','eng_name' => 'HSIUPING UNIVERSITY OF SCIENCE AND TECHNOLOGY','phone' => '886-4-24961100  #6111','username' => 'hust','email' => 'hustz%zhust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '經國管理暨健康學院','eng_name' => 'Ching Kuo Institute Of Management and Health','phone' => '886-2-24372093','username' => 'cku','email' => 'ckuz%zcku.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '華夏學校財團法人華夏科技大學','eng_name' => 'Hwa Hsia University of Technology','phone' => '886-2-89415100#1432','username' => 'hwh','email' => 'hwhz%zhwh.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '臺灣觀光學院','eng_name' => 'Taiwan Hospitality and Tourism College','phone' => '886-3-865-3906','username' => 'tht','email' => 'thtz%ztht.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '台北海洋技術學院','eng_name' => 'Taipei College of Maritime Technology','phone' => '886-2-28052088','username' => 'tcmt','email' => 'tcmtz%ztcmt.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '法鼓學校財團法人法鼓文理學院','eng_name' => 'Dharma Drum Institute of Liberal Arts','phone' => '886-24980707#5211','username' => 'dila','email' => 'dilaz%zdila.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立澎湖科技大學','eng_name' => 'National Penghu University of Science and Technology','phone' => '886-6-9264115','username' => 'npu','email' => 'npuz%znpu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '龍華科技大學','eng_name' => 'Lunghwa University of Science and Technology','phone' => '886-2-82093211','username' => 'lhu','email' => 'lhuz%zlhu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '建國科技大學','eng_name' => 'ChienKuo Technology University','phone' => '886-4-7111111','username' => 'ctu','email' => 'ctuz%zctu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '臺北市立大學','eng_name' => 'University of Taipei','phone' => '02-2311-3040 EXT 1152','username' => 'utaipei','email' => 'utaipeiz%zutaipei.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中華醫事科技大學','eng_name' => 'Chung Hwa University of Medical Technology','phone' => '886-6-2674567-230','username' => 'hwai','email' => 'hwaiz%zhwai.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '廣亞學校財團法人育達科技大學','eng_name' => 'YU DA UNIVERSITY OF SCIENCE AND TECHNOLOGY','phone' => '886-37-651188 分機8910','username' => 'ydu','email' => 'yduz%zydu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '蘭陽技術學院','eng_name' => 'LAN YANG INSTITUTE OF TECHNOLOGY','phone' => '886-03-9771997','username' => 'fit','email' => 'fitz%zfit.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '黎明技術學院','eng_name' => 'LEE-MING INSTITUTE OF TECHNOLOGY','phone' => '886-2-29097811#1165','username' => 'lit','email' => 'litz%zlit.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '長庚學校財團法人長庚科技大學','eng_name' => 'Chang Gung University of Science and Technology','phone' => '886-3-2118999 轉5533','username' => 'cgust','email' => 'cgustz%zcgust.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '崇右技術學院','eng_name' => 'Chungyu Institute of Technology','phone' => '886-2-24237785轉218','username' => 'cit','email' => 'citz%zcit.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '大同技術學院','eng_name' => 'TATUNG  INSTITUTE  OF  COMMERCE  AND  TECHNOLOGY','phone' => '886-5-2223124轉209','username' => 'ttc','email' => 'ttcz%zttc.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '亞太學校財團法人亞太創意技術學院','eng_name' => 'Asia-Pacific Institute of Creativity','phone' => '886-37-605599','username' => 'apic','email' => 'apicz%zapic.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '高鳳數位內容學院','eng_name' => 'KAO FONG COLLEGE OF DIGITAL CONTENTS','phone' => '886-8-7626365','username' => 'kfcdc','email' => 'kfcdcz%zkfcdc.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立屏東大學','eng_name' => 'National Pingtung University','phone' => '886-8-766-3800','username' => 'nptu','email' => 'nptuz%znptu.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '馬偕醫學院','eng_name' => 'Mackay Medical College','phone' => '886-2-26360303','username' => 'mmc','email' => 'mmcz%zmmc.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺灣戲曲學院','eng_name' => 'National Taiwan College of Performing Arts','phone' => '886-2-27962666#1220','username' => 'tcpa','email' => 'tcpaz%ztcpa.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '基督教臺灣浸會神學院','eng_name' => 'Taiwan Baptist Christian Seminary','phone' => '886-2-27203140 #143','username' => 'tbts','email' => 'tbtsz%ztbts.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '臺北基督學院','eng_name' => 'Christ\'s College Taipei','phone' => '02-2809-7661 ext. 2220','username' => 'cct','email' => 'cctz%zcct.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '一貫道天皇基金會一貫道天皇學院','eng_name' => 'I-Kuan Tao College','phone' => '07-6872139','username' => 'iktc','email' => 'iktcz%ziktc.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '一貫道崇德學院','eng_name' => 'Chong-De School','phone' => '886-49-2988675','username' => 'iktcds','email' => 'iktcdsz%ziktcds.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '台灣神學研究學院','eng_name' => 'Taiwan Graduate School of Theology','phone' => '886-2-28814472','username' => 'tgst','email' => 'tgstz%ztgst.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '國立臺灣師範大學僑生先修部','eng_name' => 'National Taiwan Normal University Division of Preparatory Programs for Overseas Chinese Students','phone' => '886-2-77148888','username' => 'nups','email' => 'nupsz%znups.edu.tw','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
        ];

        foreach ($schools as $school) {
            //$password = $this->random_str(15);

            $password = $school['username'];

            $email = str_replace('z%z', '@', $school['email']);

            $school = array_replace($school, ['email' => $email]);

            $school += ['password' => Hash::make(hash('sha256', $password))];

            DB::table('users')->insert($school);

            if (Storage::disk('local')->exists($start.'-UserSeeder.log')) {
                Storage::disk('local')->append($start.'-UserSeeder.log', 'name: '.$school['name'].', username: '.$school['username'].', password: '.$password);
            } else {
                Storage::disk('local')->put($start.'-UserSeeder.log', 'name: '.$school['name'].', username: '.$school['username'].', password: '.$password);
            }
        }
    }

    /**
     * Generate a random string, using a cryptographically secure
     * pseudorandom number generator (random_int)
     *
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     *
     * @param int $length      How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     */
    function random_str($length)
    {
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+~';

        $str = '';

        $max = mb_strlen($keyspace, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }

        return $str;
    }
}
