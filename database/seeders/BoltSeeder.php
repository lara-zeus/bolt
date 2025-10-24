<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JsonException;

class BoltSeeder extends Seeder
{
    /**
     * @throws JsonException
     */
    public function run(): void
    {
        $collection = DB::table(config('zeus-bolt.table-prefix') . 'collections')->insertGetId([
            'name' => 'numbers range 1-5',
            'values' => json_encode([
                [
                    'itemKey' => '1',
                    'itemValue' => 'One',
                    'itemIsDefault' => false,
                ],
                [
                    'itemKey' => '2',
                    'itemValue' => 'Two',
                    'itemIsDefault' => false,
                ],
                [
                    'itemKey' => '3',
                    'itemValue' => 'Three',
                    'itemIsDefault' => false,
                ],
                [
                    'itemKey' => '4',
                    'itemValue' => 'Four',
                    'itemIsDefault' => false,
                ],
                [
                    'itemKey' => '5',
                    'itemValue' => 'Five',
                    'itemIsDefault' => false,
                ],
            ], JSON_THROW_ON_ERROR),
            'created_at' => now(),
        ]);
        $collection_2 = DB::table(config('zeus-bolt.table-prefix') . 'collections')->insertGetId([
            'name' => 'yes no maybe list',
            'values' => json_encode([
                [
                    'itemKey' => 'yes',
                    'itemValue' => 'Yes',
                    'itemIsDefault' => false,
                ],
                [
                    'itemKey' => 'no',
                    'itemValue' => 'No',
                    'itemIsDefault' => false,
                ],
                [
                    'itemKey' => 'maybe',
                    'itemValue' => 'Maybe',
                    'itemIsDefault' => false,
                ],
            ], JSON_THROW_ON_ERROR),
            'created_at' => now(),
        ]);

        $category = DB::table(config('zeus-bolt.table-prefix') . 'categories')->insertGetId([
            'name' => json_encode(['en' => 'General Forms', 'ar' => 'النماذج العامة'], JSON_THROW_ON_ERROR),
            'description' => json_encode(['en' => 'all other Forms', 'ar' => 'كافة النماذج'], JSON_THROW_ON_ERROR),
            'slug' => 'general-forms',
            'created_at' => now(),
        ]);

        $form = DB::table(config('zeus-bolt.table-prefix') . 'forms')->insertGetId([
            'name' => json_encode(['en' => 'Feedback', 'ar' => 'التقييم'], JSON_THROW_ON_ERROR),
            'slug' => 'feedback',
            'options' => json_encode([
                'confirmation-message' => 'Thank you for your feedback',
                'show-as' => 'page',
                'require-login' => false,
                'emails-notification' => null,
                'web-hook' => null,
            ], JSON_THROW_ON_ERROR),
            'category_id' => $category,
            'user_id' => 1,
            'start_date' => null,
            'end_date' => null,
            'ordering' => 1,
            'is_active' => 1,
            'description' => json_encode(['en' => 'send us your Feedback about our service', 'ar' => 'شاركنا تقييمك على خدماتنا'], JSON_THROW_ON_ERROR),
            'details' => json_encode(['en' => 'please use the same email address you used on registration, so we can add points to your account', 'ar' => 'الرجاء استخدام نفس البريد الإلكتروني المستخدم في التسجيل لاضافة النقاط لحسابك'], JSON_THROW_ON_ERROR),
            'created_at' => now(),
        ]);

        $section1 = DB::table(config('zeus-bolt.table-prefix') . 'sections')->insertGetId([
            'name' => json_encode(['en' => 'your info', 'ar' => 'بياناتك الشخصية'], JSON_THROW_ON_ERROR),
            'form_id' => $form,
            'created_at' => now(),
        ]);
        $section2 = DB::table(config('zeus-bolt.table-prefix') . 'sections')->insertGetId([
            'name' => json_encode(['en' => 'feedback', 'ar' => 'التقييم'], JSON_THROW_ON_ERROR),
            'form_id' => $form,
            'created_at' => now(),
        ]);

        $section1_field_1 = DB::table(config('zeus-bolt.table-prefix') . 'fields')->insertGetId([
            'name' => json_encode(['en' => 'your Name', 'ar' => 'الاسم كاملا'], JSON_THROW_ON_ERROR),
            'section_id' => $section1,
            'ordering' => 1,
            'options' => json_encode([
                'dateType' => 'string',
                'is_required' => true,
            ], JSON_THROW_ON_ERROR),
            'type' => '\LaraZeus\Bolt\Fields\Classes\TextInput',
            'created_at' => now(),
        ]);
        $section1_field_2 = DB::table(config('zeus-bolt.table-prefix') . 'fields')->insertGetId([
            'name' => json_encode(['en' => 'your Email', 'ar' => 'البريد الإلكتروني'], JSON_THROW_ON_ERROR),
            'section_id' => $section1,
            'ordering' => 2,
            'options' => json_encode([
                'dateType' => 'email',
                'is_required' => true,
            ], JSON_THROW_ON_ERROR),
            'type' => '\LaraZeus\Bolt\Fields\Classes\TextInput',
            'created_at' => now(),
        ]);
        $section2_field_1 = DB::table(config('zeus-bolt.table-prefix') . 'fields')->insertGetId([
            'name' => json_encode(['en' => 'rate your experience', 'ar' => 'تقييم تجربتك معنا'], JSON_THROW_ON_ERROR),
            'section_id' => $section2,
            'ordering' => 1,
            'options' => json_encode([
                'dataSource' => '1',
                'is_required' => true,
                'is_inline' => true,
            ], JSON_THROW_ON_ERROR),
            'type' => '\LaraZeus\Bolt\Fields\Classes\Radio',
            'created_at' => now(),
        ]);
        $section2_field_2 = DB::table(config('zeus-bolt.table-prefix') . 'fields')->insertGetId([
            'name' => json_encode(['en' => 'would you recommend our services to others', 'ar' => 'هل تنصح الآخرين باستخدام خدماتنا'], JSON_THROW_ON_ERROR),
            'section_id' => $section2,
            'ordering' => 2,
            'options' => json_encode([
                'dataSource' => '2',
                'is_required' => true,
            ], JSON_THROW_ON_ERROR),
            'type' => '\LaraZeus\Bolt\Fields\Classes\Select',
            'created_at' => now(),
        ]);

        $response_1 = DB::table(config('zeus-bolt.table-prefix') . 'responses')->insertGetId([
            'form_id' => $form,
            'user_id' => null,
            'status' => 'NEW',
            'notes' => null,
            'created_at' => now(),
        ]);

        $response_1_field_1 = DB::table(config('zeus-bolt.table-prefix') . 'field_responses')->insertGetId([
            'form_id' => $form,
            'field_id' => $section1_field_1,
            'response_id' => $response_1,
            'response' => 'My First Name',
            'created_at' => now(),
        ]);
        $response_1_field_2 = DB::table(config('zeus-bolt.table-prefix') . 'field_responses')->insertGetId([
            'form_id' => $form,
            'field_id' => $section1_field_2,
            'response_id' => $response_1,
            'response' => 'its@not.important',
            'created_at' => now(),
        ]);
        $response_1_field_3 = DB::table(config('zeus-bolt.table-prefix') . 'field_responses')->insertGetId([
            'form_id' => $form,
            'field_id' => $section2_field_1,
            'response_id' => $response_1,
            'response' => '2',
            'created_at' => now(),
        ]);
        $response_1_field_4 = DB::table(config('zeus-bolt.table-prefix') . 'field_responses')->insertGetId([
            'form_id' => $form,
            'field_id' => $section2_field_2,
            'response_id' => $response_1,
            'response' => 'Maybe',
            'created_at' => now(),
        ]);

        $response_2 = DB::table(config('zeus-bolt.table-prefix') . 'responses')->insertGetId([
            'form_id' => $form,
            'user_id' => 2,
            'status' => 'NEW',
            'notes' => null,
            'created_at' => now(),
        ]);

        $response_2_field_1 = DB::table(config('zeus-bolt.table-prefix') . 'field_responses')->insertGetId([
            'form_id' => $form,
            'field_id' => $section1_field_1,
            'response_id' => $response_2,
            'response' => 'My First Name',
            'created_at' => now(),
        ]);
        $response_2_field_2 = DB::table(config('zeus-bolt.table-prefix') . 'field_responses')->insertGetId([
            'form_id' => $form,
            'field_id' => $section1_field_2,
            'response_id' => $response_2,
            'response' => 'its@not.important',
            'created_at' => now(),
        ]);
        $response_2_field_3 = DB::table(config('zeus-bolt.table-prefix') . 'field_responses')->insertGetId([
            'form_id' => $form,
            'field_id' => $section2_field_1,
            'response_id' => $response_2,
            'response' => '2',
            'created_at' => now(),
        ]);
        $response_2_field_4 = DB::table(config('zeus-bolt.table-prefix') . 'field_responses')->insertGetId([
            'form_id' => $form,
            'field_id' => $section2_field_2,
            'response_id' => $response_2,
            'response' => 'maybe',
            'created_at' => now(),
        ]);
    }
}
