<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        return [
            'school_class_id' => SchoolClass::factory(),
            'name' => $this->faker->word(),
            'code' => strtoupper($this->faker->lexify('??')),
            'description' => $this->faker->sentence(),
        ];
    }
}
