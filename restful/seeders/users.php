<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ip_long = array(
            array('607649792', '608174079'), // 36.56.0.0-36.63.255.255
            array('1038614528', '1039007743'), // 61.232.0.0-61.237.255.255
            array('1783627776', '1784676351'), // 106.80.0.0-106.95.255.255
            array('2035023872', '2035154943'), // 121.76.0.0-121.77.255.255
            array('2078801920', '2079064063'), // 123.232.0.0-123.235.255.255
            array('-1950089216', '-1948778497'), // 139.196.0.0-139.215.255.255
            array('-1425539072', '-1425014785'), // 171.8.0.0-171.15.255.255
            array('-1236271104', '-1235419137'), // 182.80.0.0-182.92.255.255
            array('-770113536', '-768606209'), // 210.25.0.0-210.47.255.255
            array('-569376768', '-564133889'), // 222.16.0.0-222.95.255.255
        );
        $begin = strtotime('-5 year + 100 day');
        $end = strtotime('+1 month + 10 day');

        for ($i=0; $i<120; $i++) {
            $rand_key = mt_rand(0, 9);
            \Hyperf\DbConnection\Db::table('users')->insert([
                'name' => \Hyperf\Utils\Str::random(12),
                'group_id' => rand(0,5),
                'password' => \Hyperf\Utils\Str::random(64),
                'gender' => ['男','女','保密'][rand(0,2)],
                'intro' => \Hyperf\Utils\Str::random(220),
                'ip_address' => long2ip(mt_rand((int) $ip_long[$rand_key][0], (int) $ip_long[$rand_key][1])),
                'birthday' => date("Y-m-d H:i:s", rand($begin, $end)),
                'created_at' => date("Y-m-d H:i:s", rand($begin, $end)),
                'updated_at' => date("Y-m-d H:i:s", strtotime('-1 month')),
            ]);
        }
    }
}
