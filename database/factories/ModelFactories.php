<?php

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
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'student_id' => $faker->creditCardNumber,
    ];
});

$factory->define(\App\Subject::class, function(Faker $faker){
    $name = $faker->name;
   return [
      'user_id' => function () {
        return factory('App\User')->create()->id;
      },
       'name' => $name,
       'description' => $faker->sentence,
       'slug' => Str::slug($name. '-'. Carbon\Carbon::now()->format('H:i:s')),
   ] ;
});

$factory->state(App\User::class, 'lecturer', function() {
    return [
        'type' => 1,
    ];
});

$factory->define(\App\SubjectGroup::class, function(Faker $faker){
    return [
        'subject_id' => function () {
            return factory('App\Subject')->create()->id;
        },
        'name' => $faker->domainWord,
        'code' => \App\SubjectGroup::generateUniqueCode(),
    ];
});

$factory->define(\App\SubjectGroupUser::class, function(Faker $faker){
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'group_id' => function () {
            return factory('App\SubjectGroup')->create()->id;
        },
    ];
});

$factory->define(\App\Task::class, function(Faker $faker){
    $beginTime = $faker->dateTimeBetween($startDate = 'now', $endDate = '+2 years');
    $name = $faker->sentence;
    return [
        'group_id' => function () {
            return factory('App\SubjectGroup')->create()->id;
        },
        'name' => $name,
        'description' => $faker->paragraph(3),
        'startDate'=> $beginTime->format('Y-m-d H:i'),
        'deadline' => $beginTime->add(\DateInterval::createFromDateString('+2 weeks'))->format('Y-m-d H:i'),
        'slug' => \App\Task::generateUniqueSlug(Str::slug($name)),
    ];
});

$factory->define(\App\Submission::class, function(Faker $faker){
    $user = factory('App\User')->create();
    $task = factory('App\Task')->create(['group_id' => factory('App\SubjectGroupUser')->create(['user_id' => $user->id])->group_id]);
    return [
        'user_id' => $user->id,
        'task_id' => $task->id,
        's_comment' => $faker->sentence,
        'r_comment' => $faker->sentence,
        'mark' => $faker->numberBetween(0, 5),
    ];
});

