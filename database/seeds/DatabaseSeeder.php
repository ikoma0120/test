<?php

use App\User;
use App\Article;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $this->call('UsersTableSeeder');  // 追加
        $this->call('ArticlesTableSeeder');

            Model::reguard();
    }

}

// 追加
class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'name' => 'root',
            'email' => 'root@sample.com',
            'password' => bcrypt('password')
        ]);
    }
}

class ArticlesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('articles')->delete();

        $user = User::all()->first();
        $faker = Faker::create('en_US');

        for ($i = 0; $i < 10; $i++) {
            // Article::create([
            //  'title' => $faker->sentence(),
            //  'body' => $faker->paragraph(),
            //  'published_at' => CarbonCarbon::today(),
            // ]);

            // 変更
            $article = new Article([
                'title' => $faker->sentence(),
                'body' => $faker->paragraph(),
                'published_at' => Carbon::now(),
            ]);
            $user->articles()->save($article);  // $userと関連付けて $articleを保存
        }
    }
}
