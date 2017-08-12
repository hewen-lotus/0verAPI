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
                    'job_title' => '', 'name' => '管理者一號',
                    'eng_name' => 'admin1',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'admin2',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'b@a.a',
                    'job_title' => '', 'name' => '管理者二號',
                    'eng_name' => 'admin2',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'admin3',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'a@b.a',
                    'job_title' => '', 'name' => '管理者三號',
                    'eng_name' => 'admin2',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'editor1',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'a@a.a',
                    'job_title' => '', 'name' => 'A編輯',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'editor2',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'b@a.a',
                    'job_title' => '', 'name' => 'B編輯',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'editor3',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'c@a.a',
                    'job_title' => '', 'name' => 'C編輯',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'reviewer1',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'z@a.a',
                    'job_title' => '', 'name' => '審核一號',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'reviewer2',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'x@a.a',
                    'job_title' => '', 'name' => '審核二號',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'reviewer3',
                    'password' => Hash::make(hash('sha256', 'admin123!@#')),
                    'email' => 'c@b.a',
                    'job_title' => '', 'name' => '審核三號',
                    'eng_name' => 'english_name',
                    'phone' => '0912345678',
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ]
            ]);
        }

        $schools = [ // z%z -> @
            ['username' => '2017ntu01','email' => 'ntu@ntu.edu.tw','name' => '國立臺灣大學','eng_name' => 'National  Taiwan University','phone' => '886-2-33662388轉203','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ncku02','email' => 'ncku@ncku.edu.tw','name' => '國立成功大學','eng_name' => 'National Cheng Kung University','phone' => '886-6-2757575','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ncyu03','email' => 'ncyu@ncyu.edu.tw','name' => '國立嘉義大學','eng_name' => 'National Chiayi University','phone' => '886-5-2717296','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ncnu04','email' => 'ncnu@ncnu.edu.tw','name' => '周楷嘉','eng_name' => 'National Chi Nan University','phone' => '886-49-2918305','job_title' => '幹事','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nchu05','email' => 'nchu@nchu.edu.tw','name' => '國立中興大學','eng_name' => 'National Chung Hsing University','phone' => '886-4-22873181','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ccu06','email' => 'ccu@ccu.edu.tw','name' => '國立中正大學','eng_name' => 'National Chung Cheng University','phone' => '886-5-2720411','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntnu07','email' => 'ntnu@ntnu.edu.tw','name' => '國立臺灣師範大學','eng_name' => 'National Taiwan Normal University','phone' => '886-2-7734-3076','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ndhu08','email' => 'ndhu@ndhu.edu.tw','name' => '國立東華大學','eng_name' => 'National Dong Hwa University','phone' => '886-3-863-4113','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntou09','email' => 'ntou@ntou.edu.tw','name' => '國立臺灣海洋大學','eng_name' => 'National Taiwan Ocean University','phone' => '886-2-24622192','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntpu10','email' => 'ntpu@ntpu.edu.tw','name' => '國立臺北大學','eng_name' => 'National Taipei University','phone' => '886-2-86741111#66122','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nctu11','email' => 'nctu@nctu.edu.tw','name' => '國立交通大學','eng_name' => 'National Chiao Tung University','phone' => '886-3-5131399','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nuk12','email' => 'nuk@nuk.edu.tw','name' => '國立高雄大學','eng_name' => 'National University of Kaohsiung','phone' => '886-7-5919000#8240~8243','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nccu13','email' => 'nccu@nccu.edu.tw','name' => '國立政治大學','eng_name' => 'National Chengchi University','phone' => '886-2-29387892','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017niu14','email' => 'niu@niu.edu.tw','name' => '國立宜蘭大學','eng_name' => 'National Ilan University','phone' => '886-3-9357400','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ncu15','email' => 'ncu@ncu.edu.tw','name' => '國立中央大學','eng_name' => 'National Central University','phone' => '886-3-4227151轉57141','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nuu16','email' => 'nuu@nuu.edu.tw','name' => '國立聯合大學','eng_name' => 'National United University','phone' => '886-37-381000','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nthu17','email' => 'nthu@nthu.edu.tw','name' => '國立清華大學','eng_name' => 'National Tsing Hua University','phone' => '886-3-5712861','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nutn18','email' => 'nutn@nutn.edu.tw','name' => '國立臺南大學','eng_name' => 'National University of Tainan','phone' => '886-6-2133111','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nsysu19','email' => 'nsysu@nsysu.edu.tw','name' => '國立中山大學','eng_name' => 'National Sun Yat-sen University','phone' => '886-7-5252000','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nttu20','email' => 'nttu@nttu.edu.tw','name' => '國立臺東大學','eng_name' => 'National Taitung University','phone' => '886-89-517334','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ym21','email' => 'ym@ym.edu.tw','name' => '國立陽明大學','eng_name' => 'National Yang-Ming University','phone' => '886-2-28267000 #2299,2268','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ndmctsgh22','email' => 'ndmctsgh@ndmctsgh.edu.tw','name' => '國防醫學院','eng_name' => 'National Defense Medical Center','phone' => '886-2-87926692','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ncue23','email' => 'ncue@ncue.edu.tw','name' => '國立彰化師範大學','eng_name' => 'National Changhua University of Education','phone' => '886-4-7232105','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017npue24','email' => 'npue@npue.edu.tw','name' => '國立屏東教育大學','eng_name' => 'National Pingtung University of Education','phone' => '886-8-7226141','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tmue25','email' => 'tmue@tmue.edu.tw','name' => '臺北市立教育大學','eng_name' => 'Taipei Municipal University of Education','phone' => '886-2-23113040','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntcu26','email' => 'ntcu@ntcu.edu.tw','name' => '國立臺中教育大學','eng_name' => 'National Taichung University of Education','phone' => '886-4-22183456','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nknu27','email' => 'nknu@nknu.edu.tw','name' => '國立高雄師範大學','eng_name' => 'National Kaohsiung Normal University','phone' => '886-7-7172930','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntue28','email' => 'ntue@ntue.edu.tw','name' => '國立臺北教育大學','eng_name' => 'National Taipei University of Education','phone' => '886-2-27321104轉82226','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nhcue29','email' => 'nhcue@nhcue.edu.tw','name' => '國立新竹教育大學','eng_name' => 'National Hsinchu University of Education','phone' => '886-3-5213132','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tpec31','email' => 'tpec@tpec.edu.tw','name' => '臺北市立體育學院','eng_name' => 'Taipei Physical Education College','phone' => '886-2-28718288','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntsu32','email' => 'ntsu@ntsu.edu.tw','name' => '國立體育大學','eng_name' => 'National Taiwan Sport University','phone' => '886-3-3283201','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tnua33','email' => 'tnua@tnua.edu.tw','name' => '國立臺北藝術大學','eng_name' => 'Taipei National University of the Arts','phone' => '+886-2-28961000','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntua34','email' => 'ntua@ntua.edu.tw','name' => '國立臺灣藝術大學','eng_name' => 'National Taiwan University of Arts','phone' => '886-2-22722181  #1152','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tnnua35','email' => 'tnnua@tnnua.edu.tw','name' => '國立臺南藝術大學','eng_name' => 'Tainan National University of the Arts','phone' => '886-6-6930100 #1212','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017pccu36','email' => 'pccu@pccu.edu.tw','name' => '中國文化大學','eng_name' => 'Chinese Culture University','phone' => '886-2-28610511  #11307','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tku37','email' => 'tku@tku.edu.tw','name' => '淡江大學','eng_name' => 'Tamkang University','phone' => '886-2-26215656','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017mcu38','email' => 'mcu@mcu.edu.tw','name' => '銘傳大學','eng_name' => 'Ming Chuan University','phone' => '886-2-28824564','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017thu39','email' => 'thu@thu.edu.tw','name' => '東海大學','eng_name' => 'Tunghai University','phone' => '886-4-23598900','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017usc40','email' => 'usc@usc.edu.tw','name' => '實踐大學','eng_name' => 'Shih Chien University','phone' => '886-2-25381111','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017isu41','email' => 'isu@isu.edu.tw','name' => '義守大學','eng_name' => 'I-Shou University','phone' => '886-7-6577711','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017pu42','email' => 'pu@pu.edu.tw','name' => '靜宜大學','eng_name' => 'Providence University','phone' => '886-4-26328001','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017au43','email' => 'au@au.edu.tw','name' => '真理大學','eng_name' => 'Aletheia University','phone' => '886-2-26290228','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017fcu44','email' => 'fcu@fcu.edu.tw','name' => '逢甲大學','eng_name' => 'Feng Chia University','phone' => '886-4-24517250轉2184','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017fju45','email' => 'fju@fju.edu.tw','name' => '輔仁大學','eng_name' => 'Fu Jen Catholic University','phone' => '886-2-29053142','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017cjcu46','email' => 'cjcu@cjcu.edu.tw','name' => '長榮大學','eng_name' => 'Chang Jung Christian University','phone' => '886-6-2785123','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017asia47','email' => 'asia@asia.edu.tw','name' => '亞洲大學','eng_name' => 'Asia University','phone' => '886-4-23323456 轉 6276','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017shu48','email' => 'shu@shu.edu.tw','name' => '世新大學','eng_name' => 'Shih Hsin University','phone' => '886-2-22368225','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017dyu49','email' => 'dyu@dyu.edu.tw','name' => '大葉大學','eng_name' => 'Dayeh University','phone' => '886-4-8511888','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017chu50','email' => 'chu@chu.edu.tw','name' => '中華大學','eng_name' => 'Chung Hua University','phone' => '886-3-5186221','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tsu51','email' => 'tsu@tsu.edu.tw','name' => '台灣首府大學','eng_name' => 'Taiwan Shoufu University','phone' => '886-6-5718818','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ukn52','email' => 'ukn@ukn.edu.tw','name' => '康寧大學','eng_name' => 'University of Kang Ning','phone' => '886-6-2552500','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ctbc53','email' => 'ctbc@ctbc.edu.tw','name' => '中信金融管理學院','eng_name' => 'CTBC Financial Management College','phone' => '886-6-2873337','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017mdu54','email' => 'mdu@mdu.edu.tw','name' => '明道大學','eng_name' => 'MingDao University','phone' => '886-4-8876660','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017scu55','email' => 'scu@scu.edu.tw','name' => '東吳大學','eng_name' => 'Soochow University','phone' => '886-2-28819471','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017knu56','email' => 'knu@knu.edu.tw','name' => '開南大學','eng_name' => 'Kainan University','phone' => '886-3-3412500分機1335','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017yzu57','email' => 'yzu@yzu.edu.tw','name' => '元智大學','eng_name' => 'Yuan Ze University','phone' => '886-3-4638800-2252','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017toko58','email' => 'toko@toko.edu.tw','name' => '稻江科技暨管理學院','eng_name' => 'Toko University','phone' => '886-5-3622889','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017hcu59','email' => 'hcu@hcu.edu.tw','name' => '玄奘大學','eng_name' => 'Hsuan Chuang University','phone' => '886-3-5302255 *2144','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nhu60','email' => 'nhu@nhu.edu.tw','name' => '南華大學','eng_name' => 'Nanhua University','phone' => '886-5-2721001分機1723','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017cycu61','email' => 'cycu@cycu.edu.tw','name' => '中原大學','eng_name' => 'Chung Yuan Christian University','phone' => '886-3-2651718','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017hfu62','email' => 'hfu@hfu.edu.tw','name' => '華梵大學','eng_name' => 'Huafan University','phone' => '886-2-26632102#2231','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ttu63','email' => 'ttu@ttu.edu.tw','name' => '大同大學','eng_name' => 'Tatung University','phone' => '886-2-21822928#6054','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017fgu64','email' => 'fgu@fgu.edu.tw','name' => '佛光大學','eng_name' => 'Fo Guang University','phone' => '886-3-9871000','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017cgu65','email' => 'cgu@cgu.edu.tw','name' => '長庚大學','eng_name' => 'Chang Gung University','phone' => '886-3-2118800','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017csmu66','email' => 'csmu@csmu.edu.tw','name' => '中山醫學大學','eng_name' => 'Chung Shan Medical University','phone' => '886-4-24730022','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017kmu67','email' => 'kmu@kmu.edu.tw','name' => '高雄醫學大學','eng_name' => 'Kaohsiung Medical University','phone' => '886-7-3121101#2109','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017cmu68','email' => 'cmu@cmu.edu.tw','name' => '中國醫藥大學','eng_name' => 'China Medical University','phone' => '886-4-22070165','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tmu69','email' => 'tmu@tmu.edu.tw','name' => '臺北醫學大學','eng_name' => 'Taipei Medical University','phone' => '886-2-27361661','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tcu70','email' => 'tcu@tcu.edu.tw','name' => '慈濟大學','eng_name' => 'Tzu Chi University','phone' => '886-3-8565301','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntust71','email' => 'ntust@ntust.edu.tw','name' => '國立臺灣科技大學','eng_name' => 'National Taiwan University of Science and Technology','phone' => '886-2-27301190','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017yuntech72','email' => 'yuntech@yuntech.edu.tw','name' => '國立雲林科技大學','eng_name' => 'National Yunlin University of Science and Technology','phone' => '886-5-5372637','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntut73','email' => 'ntut@ntut.edu.tw','name' => '國立臺北科技大學','eng_name' => 'National Taipei University of Technology','phone' => '886-2-27712171','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017npust74','email' => 'npust@npust.edu.tw','name' => '國立屏東科技大學','eng_name' => 'National Pingtung University of Science and Technology','phone' => '886-8-7703202','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nkfust75','email' => 'nkfust@nkfust.edu.tw','name' => '國立高雄第一科技大學','eng_name' => 'National Kaohsiung First University of Science and Technology','phone' => '886-7-6011000  #1621','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017kuas76','email' => 'kuas@kuas.edu.tw','name' => '國立高雄應用科技大學','eng_name' => 'NATIONAL KAOHSIUNG UNIVERSITY OF APPLIED SCIENCES','phone' => '886-7-3814526分機2311','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nkmu77','email' => 'nkmu@nkmu.edu.tw','name' => '國立高雄海洋科技大學','eng_name' => 'National Kaohsiung Marine University','phone' => '886-7-3617141','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nfu78','email' => 'nfu@nfu.edu.tw','name' => '國立虎尾科技大學','eng_name' => 'National Formosa University','phone' => '886-5-6315108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017npic79','email' => 'npic@npic.edu.tw','name' => '國立屏東商業技術學院','eng_name' => 'National Pingtung Institute of Commerce','phone' => '886-8-7238700','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nqu80','email' => 'nqu@nqu.edu.tw','name' => '國立金門大學','eng_name' => 'National Quemoy University','phone' => '886-82-313734','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ncut81','email' => 'ncut@ncut.edu.tw','name' => '國立勤益科技大學','eng_name' => 'National Chin-Yi University of Technology','phone' => '886-4-23924505','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nutc82','email' => 'nutc@nutc.edu.tw','name' => '國立臺中科技大學','eng_name' => 'National Taichung University of Science and Technology','phone' => '886-4-22195762','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nkuht83','email' => 'nkuht@nkuht.edu.tw','name' => '國立高雄餐旅大學','eng_name' => 'National Kaohsiung University of Hospitality and Tourism','phone' => '886-7-8060505','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntub84','email' => 'ntub@ntub.edu.tw','name' => '國立臺北商業大學','eng_name' => 'National Taipei University of Business','phone' => '886-2-23226050','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntunhs85','email' => 'ntunhs@ntunhs.edu.tw','name' => '國立臺北護理健康大學','eng_name' => 'National Taipei University of Nursing and Health Science','phone' => '02-28227101ext.2731','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017cyut86','email' => 'cyut@cyut.edu.tw','name' => '朝陽科技大學','eng_name' => 'Chaoyang University of Technology','phone' => '886-4-23331637','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017stust87','email' => 'stust@stust.edu.tw','name' => '南臺科技大學','eng_name' => 'Southern Taiwan University of Science and Technology','phone' => '886-6-2533131','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ksu88','email' => 'ksu@ksu.edu.tw','name' => '崑山科技大學','eng_name' => 'Kun Shan University','phone' => '886-6-2727175  #221','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017stu89','email' => 'stu@stu.edu.tw','name' => '樹德科技大學','eng_name' => 'Shu-Te University','phone' => '886-7-6158000','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017cnu90','email' => 'cnu@cnu.edu.tw','name' => '嘉藥學校財團法人嘉南藥理大學','eng_name' => 'Chia Nan University of Pharmacy and Science','phone' => '886-6-2664911','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017must91','email' => 'must@must.edu.tw','name' => '明新科技大學','eng_name' => 'Minghsin University of Science and Technology','phone' => '886-3-5593142#2145','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017fy92','email' => 'fy@fy.edu.tw','name' => '輔英科技大學','eng_name' => 'Fooyin University','phone' => '886-7-7811151','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017hk93','email' => 'hk@hk.edu.tw','name' => '弘光科技大學','eng_name' => 'HungKuang University','phone' => '886-4-26318652','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017csu94','email' => 'csu@csu.edu.tw','name' => '正修科技大學','eng_name' => 'Cheng Shiu University','phone' => '886-7-7358800','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017uch95','email' => 'uch@uch.edu.tw','name' => '健行科技大學','eng_name' => 'Chien Hsin University of Science and Technology','phone' => '886-3-4581196','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017vnu96','email' => 'vnu@vnu.edu.tw','name' => '萬能學校財團法人萬能科技大學','eng_name' => 'Vanung University','phone' => '886-3-4515811','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017mcut97','email' => 'mcut@mcut.edu.tw','name' => '明志科技大學','eng_name' => 'MING CHI UNIVERSITY OF TECHNOLOGY','phone' => '886-2-29089899','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017cute98','email' => 'cute@cute.edu.tw','name' => '中國科技大學','eng_name' => 'China University of Technology','phone' => '886-2-29313416','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tajen99','email' => 'tajen@tajen.edu.tw','name' => '大仁科技大學','eng_name' => 'Tajen University ','phone' => '886-8-7626903','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017kyuA0','email' => 'kyu@kyu.edu.tw','name' => '高苑科技大學','eng_name' => 'KAO YUAN UNIVERSITY','phone' => '886-7-6077914','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ltuA1','email' => 'ltu@ltu.edu.tw','name' => '嶺東科技大學','eng_name' => 'Ling Tung University','phone' => '886-4-23892088','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017sjuA2','email' => 'sju@sju.edu.tw','name' => '聖約翰科技大學','eng_name' => 'St. John\'s University','phone' => '886-2-28013131#6885','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ctustA3','email' => 'ctust@ctust.edu.tw','name' => '中臺科技大學','eng_name' => 'Central Taiwan University of Science and Technology','phone' => '886-4-22391647','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tutA4','email' => 'tut@tut.edu.tw','name' => '台南家專學校財團法人台南應用科技大學','eng_name' => 'Tainan University of Technology','phone' => '886-6-2535643','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017feuA5','email' => 'feu@feu.edu.tw','name' => '遠東科技大學','eng_name' => 'Far East University','phone' => '886-6-5979566','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ypuA6','email' => 'ypu@ypu.edu.tw','name' => '光宇學校財團法人元培醫事科技大學','eng_name' => 'Yuanpei University of Medical Technology','phone' => '886-3-6102215','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ccutA7','email' => 'ccut@ccut.edu.tw','name' => '中州學校財團法人中州科技大學','eng_name' => 'Chung Chou University of Science and Technology','phone' => '886-4-835-9000','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nkutA8','email' => 'nkut@nkut.edu.tw','name' => '南開科技大學','eng_name' => 'Nan Kai University of Technology','phone' => '886-49-2563489','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017custA9','email' => 'cust@cust.edu.tw','name' => '中華學校財團法人中華科技大學','eng_name' => 'China University of Science and Technology','phone' => '886-2-27821862','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tustB0','email' => 'tust@tust.edu.tw','name' => '大華學校財團法人大華科技大學','eng_name' => 'Ta Hwa University','phone' => '886-3-592-7700','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017dahanB1','email' => 'dahan@dahan.edu.tw','name' => '大漢技術學院','eng_name' => 'Dahan Institute of Technology','phone' => '886-3-8210-888轉1820','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017wzuB2','email' => 'wzu@wzu.edu.tw','name' => '文藻外語大學','eng_name' => 'Wenzao Ursuline University of Languages','phone' => '886-7-3426031#2643','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017justB3','email' => 'just@just.edu.tw','name' => '景文科技大學','eng_name' => 'Jinwen University of Science and Technology','phone' => '886-2-82122000','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tcustB4','email' => 'tcust@tcust.edu.tw','name' => '慈濟學校財團法人慈濟科技大學','eng_name' => 'Tzu Chi University of Science and Technology','phone' => '886-3-8572158','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ytitB5','email' => 'ytit@ytit.edu.tw','name' => '永達技術學院','eng_name' => 'Yung Ta Institute of Technology & Commerce','phone' => '886-8-7233733','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017fotechB6','email' => 'fotech@fotech.edu.tw','name' => '和春技術學院','eng_name' => 'Fortune Institute of Technology','phone' => '886-7-7889888','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017oitB7','email' => 'oit@oit.edu.tw','name' => '亞東技術學院','eng_name' => 'Oriental Institute of Technology','phone' => '886-2-77387708','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tpcuB8','email' => 'tpcu@tpcu.edu.tw','name' => '城市學校財團法人臺北城市科技大學','eng_name' => 'Taipei Chengshih University of Science and Technology','phone' => '886-2-28927154','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nanyaB9','email' => 'nanya@nanya.edu.tw','name' => '南亞科技學校財團法人南亞技術學院','eng_name' => 'Nanya Institute of Technology','phone' => '886-3-4361070','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017wfuC0','email' => 'wfu@wfu.edu.tw','name' => '吳鳳學校財團法人吳鳳科技大學','eng_name' => 'WuFeng University','phone' => '886-5-2269954','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tnuC1','email' => 'tnu@tnu.edu.tw','name' => '東南科技大學','eng_name' => 'Tungnan University','phone' => '+886-2-86625948','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ocuC2','email' => 'ocu@ocu.edu.tw','name' => '僑光科技大學','eng_name' => 'Overseas Chinese University','phone' => '886-4-27016855','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017chihleeC3','email' => 'chihlee@chihlee.edu.tw','name' => '致理科技大學','eng_name' => 'Chihlee University of Technology','phone' => '886-2-22580500','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017hwuC4','email' => 'hwu@hwu.edu.tw','name' => '醒吾科技大學','eng_name' => 'Hsing Wu University of Science and Technology','phone' => '886-2-26015310#1201','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017takmingC5','email' => 'takming@takming.edu.tw','name' => '德明財經科技大學','eng_name' => 'Takming University of Science and Technology','phone' => '886-2-77290799','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017twuC6','email' => 'twu@twu.edu.tw','name' => '環球學校財團法人環球科技大學','eng_name' => 'TransWorld University','phone' => '886-5-5370988 # 2230~2236','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017meihoC7','email' => 'meiho@meiho.edu.tw','name' => '美和學校財團法人美和科技大學','eng_name' => 'Meiho University','phone' => '886-8-7799821 #8144','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017dlitC8','email' => 'dlit@dlit.edu.tw','name' => '德霖技術學院','eng_name' => 'De Lin Institute of Technology','phone' => '886-2-22733567 轉 688-693','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017njuC9','email' => 'nju@nju.edu.tw','name' => '南榮學校財團法人南榮科技大學','eng_name' => 'Nan Jeon University of Science and Technology','phone' => '886-6-652-3111#1903','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tfD0','email' => 'tf@tf.edu.tw','name' => '東方學校財團法人東方設計學院','eng_name' => 'TUNGFANG DESIGN INSTITUTE','phone' => '886-7-6939583','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017hustD1','email' => 'hust@hust.edu.tw','name' => '修平學校財團法人修平科技大學','eng_name' => 'HSIUPING UNIVERSITY OF SCIENCE AND TECHNOLOGY','phone' => '886-4-24961100  #6111','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ckuD2','email' => 'cku@cku.edu.tw','name' => '經國管理暨健康學院','eng_name' => 'Ching Kuo Institute Of Management and Health','phone' => '886-2-24372093','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017hwhD3','email' => 'hwh@hwh.edu.tw','name' => '華夏學校財團法人華夏科技大學','eng_name' => 'Hwa Hsia University of Technology','phone' => '886-2-89415100#1432','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017thtD4','email' => 'tht@tht.edu.tw','name' => '臺灣觀光學院','eng_name' => 'Taiwan Hospitality and Tourism College','phone' => '886-3-865-3906','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tcmtD5','email' => 'tcmt@tcmt.edu.tw','name' => '台北海洋技術學院','eng_name' => 'Taipei College of Maritime Technology','phone' => '886-2-28052088','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017dilaD6','email' => 'dila@dila.edu.tw','name' => '法鼓學校財團法人法鼓文理學院','eng_name' => 'Dharma Drum Institute of Liberal Arts','phone' => '886-24980707#5211','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017npuD7','email' => 'npu@npu.edu.tw','name' => '國立澎湖科技大學','eng_name' => 'National Penghu University of Science and Technology','phone' => '886-6-9264115','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017lhuD8','email' => 'lhu@lhu.edu.tw','name' => '龍華科技大學','eng_name' => 'Lunghwa University of Science and Technology','phone' => '886-2-82093211','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ctuD9','email' => 'ctu@ctu.edu.tw','name' => '建國科技大學','eng_name' => 'ChienKuo Technology University','phone' => '886-4-7111111','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017utaipeiE0','email' => 'utaipei@utaipei.edu.tw','name' => '臺北市立大學','eng_name' => 'University of Taipei','phone' => '02-2311-3040 EXT 1152','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017hwaiE1','email' => 'hwai@hwai.edu.tw','name' => '中華醫事科技大學','eng_name' => 'Chung Hwa University of Medical Technology','phone' => '886-6-2674567-230','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017yduE2','email' => 'ydu@ydu.edu.tw','name' => '廣亞學校財團法人育達科技大學','eng_name' => 'YU DA UNIVERSITY OF SCIENCE AND TECHNOLOGY','phone' => '886-37-651188 分機8910','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017fitE3','email' => 'fit@fit.edu.tw','name' => '蘭陽技術學院','eng_name' => 'LAN YANG INSTITUTE OF TECHNOLOGY','phone' => '886-03-9771997','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017litE4','email' => 'lit@lit.edu.tw','name' => '黎明技術學院','eng_name' => 'LEE-MING INSTITUTE OF TECHNOLOGY','phone' => '886-2-29097811#1165','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017cgustE5','email' => 'cgust@cgust.edu.tw','name' => '長庚學校財團法人長庚科技大學','eng_name' => 'Chang Gung University of Science and Technology','phone' => '886-3-2118999 轉5533','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017citE6','email' => 'cit@cit.edu.tw','name' => '崇右技術學院','eng_name' => 'Chungyu Institute of Technology','phone' => '886-2-24237785轉218','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ttcE7','email' => 'ttc@ttc.edu.tw','name' => '大同技術學院','eng_name' => 'TATUNG  INSTITUTE  OF  COMMERCE  AND  TECHNOLOGY','phone' => '886-5-2223124轉209','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017apicE8','email' => 'apic@apic.edu.tw','name' => '亞太學校財團法人亞太創意技術學院','eng_name' => 'Asia-Pacific Institute of Creativity','phone' => '886-37-605599','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017kfcdcE9','email' => 'kfcdc@kfcdc.edu.tw','name' => '高鳳數位內容學院','eng_name' => 'KAO FONG COLLEGE OF DIGITAL CONTENTS','phone' => '886-8-7626365','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nptuF0','email' => 'nptu@nptu.edu.tw','name' => '國立屏東大學','eng_name' => 'National Pingtung University','phone' => '886-8-766-3800','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017mmcF1','email' => 'mmc@mmc.edu.tw','name' => '馬偕醫學院','eng_name' => 'Mackay Medical College','phone' => '886-2-26360303','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tcpaF2','email' => 'tcpa@tcpa.edu.tw','name' => '國立臺灣戲曲學院','eng_name' => 'National Taiwan College of Performing Arts','phone' => '886-2-27962666#1220','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tbtsF3','email' => 'tbts@tbts.edu.tw','name' => '基督教臺灣浸會神學院','eng_name' => 'Taiwan Baptist Christian Seminary','phone' => '886-2-27203140 #143','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017cctF4','email' => 'cct@cct.edu.tw','name' => '臺北基督學院','eng_name' => 'Christ\'s College Taipei','phone' => '02-2809-7661 ext. 2220','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017iktcF5','email' => 'iktc@iktc.edu.tw','name' => '一貫道天皇基金會一貫道天皇學院','eng_name' => 'I-Kuan Tao College','phone' => '07-6872139','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017iktcdsF6','email' => 'iktcds@iktcds.edu.tw','name' => '一貫道崇德學院','eng_name' => 'Chong-De School','phone' => '886-49-2988675','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017tgstF7','email' => 'tgst@tgst.edu.tw','name' => '台灣神學研究學院','eng_name' => 'Taiwan Graduate School of Theology','phone' => '886-2-28814472','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017nupsFF','email' => 'nups@nups.edu.tw','name' => '國立臺灣師範大學僑生先修部','eng_name' => 'National Taiwan Normal University Division of Preparatory Programs for Overseas Chinese Students','phone' => '886-2-77148888','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30A','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學A','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30B','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學B','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30C','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學C','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30D','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學D','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30E','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學E','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30F','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學F','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30G','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學G','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30H','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學H','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30I','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學I','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntupes30J','email' => 'ntupes@ntupes.edu.tw','name' => '國立臺灣體育運動大學J','eng_name' => 'National Taiwan University of Sport','phone' => '886-4-22213108','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['username' => '2017ntu02','email' => 'ntu@ntu.edu.tw','name' => '國立臺灣大學','eng_name' => 'National  Taiwan University','phone' => '886-2-33662388轉203','job_title' => '','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
        ];

        $insert_data = [];

        foreach ($schools as $school) {
            //$password = $this->random_str(15);

            $password = $school['username'];

            $email = str_replace('z%z', '@', $school['email']);

            $school = array_replace($school, ['email' => $email]);

            $school += ['password' => Hash::make(hash('sha256', $password))];

            $insert_data[] = $school;

            if (Storage::disk('local')->exists($start.'-UserSeeder.log')) {
                Storage::disk('local')->append($start.'-UserSeeder.log', 'name: '.$school['name'].', username: '.$school['username'].', password: '.$password);
            } else {
                Storage::disk('local')->put($start.'-UserSeeder.log', 'name: '.$school['name'].', username: '.$school['username'].', password: '.$password);
            }
        }

        DB::table('users')->insert($insert_data);
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
