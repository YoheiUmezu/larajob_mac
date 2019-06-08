<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'user_type'=>'seeker',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'user_id' =>App\User::all()->random()->id,//user tableからランダムにidを持ってくる
        'cname'=>$name=$faker->company,
        'slug'=>str_slug($name),
        'address'=>$faker->address,
        'phone'=>$faker->phoneNumber,
        'website'=>$faker->domainName,
        'company_logo'=>'avotor/man.jpg',//publicにフォルダ作って写真入れた
        'cover_photo'=>'cover/indeed.jpg',//publicにフォルダ作って写真入れた
        'slogan'=>'learn-earn and grow',//例を入れる
        'description'=>$faker->paragraph(rand(2,10))//2~10パラグラフの間でランダムに作成
    ];
});

$factory->define(App\Job::class, function (Faker $faker) {
    return [
        'user_id' =>App\User::all()->random()->id,//user tableからランダムにidを持ってくる
        'company_id'=>App\Company::all()->random()->id,//company tableからランダムにidを持ってくる
        'title'=>$title=$faker->text,
        'slug'=>str_slug($title),
        'position'=>$faker->jobTitle,
        'address'=>$faker->address,
        'category_id'=>rand(1,5),
        'type'=>'fulltime',
        'status'=>rand(0,1),//statusのデフォルト
        'description'=>$faker->paragraph(rand(2,10)),
        'roles'=>$faker->text,
        'last_date'=>$faker->DateTime
    ];
});
