<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoltSectionsSeeder extends Seeder
{
    /**
     * @throws \JsonException
     */
    public function run()
    {
        $category = DB::table(config('zeus-bolt.table-prefix') . 'categories')->insertGetId([
            'name' => json_encode(['en' => 'Dynamic'], JSON_THROW_ON_ERROR),
            'description' => json_encode(['en' => 'Dynamic Form'], JSON_THROW_ON_ERROR),
            'slug' => 'bolt-dynamic',
            'created_at' => now(),
        ]);

        $form = DB::table(config('zeus-bolt.table-prefix') . 'forms')->insertGetId([
            'description' => '{"en":"you can setup your form to show/hide sections based on field values"}',
            'slug' => 'dynamic-sections',
            'details' => '{"en":"<p><a href=\\"https:\\/\\/larazeus.com\\/bolt-pro\\">Get Bolt Pro now, extra fields are available now, and more are on the way.<\\/a><\\/p>","pt":"<p><a href=\\"https:\\/\\/larazeus.com\\/bolt-pro\\">Get Bolt Pro now, extra fields are available now, and more are on the way.<\\/a><\\/p>","ko":"<p><a href=\\"https:\\/\\/larazeus.com\\/bolt-pro\\">Get Bolt Pro now, extra fields are available now, and more are on the way.<\\/a><\\/p>"}',
            'options' => '{"confirmation-message":"<p>Thank you for testing out Bolt Pro \\ud83d\\ude42<\\/p>","require-login":false,"show-as":"page","emails-notification":null}',
            'name' => json_encode(
                ['en' => 'Dynamic Sections', 'pt' => 'Dynamic Sections', 'ko' => 'Dynamic Sections'],
                JSON_THROW_ON_ERROR
            ),
            'category_id' => $category,
            'user_id' => 1,
            'start_date' => null,
            'end_date' => null,
            'ordering' => 1,
            'is_active' => 1,
            'created_at' => now(),
        ]);

        $section4 = DB::table(config('zeus-bolt.table-prefix') . 'sections')->insertGetId([
            'form_id' => $form,
            'name' => '{"en":"Lang","pt":"Lang","ko":"Lang"}',
            'created_at' => '2023-10-28 11:11:20',
            'aside' => '1',
            'options' => '{"visibility":{"active":false}}',
        ]);

        $section1 = DB::table(config('zeus-bolt.table-prefix') . 'sections')->insertGetId([
            'form_id' => $form,
            'name' => '{"en":"KO  form","pt":"KO  form","ko":"KO  form"}',
            'created_at' => '2023-10-28 11:13:25',
        ]);

        $section2 = DB::table(config('zeus-bolt.table-prefix') . 'sections')->insertGetId([
            'form_id' => $form,
            'name' => '{"en":"PT form","pt":"PT form","ko":"PT form"}',
            'created_at' => '2023-10-28 11:12:40',
        ]);

        $section3 = DB::table(config('zeus-bolt.table-prefix') . 'sections')->insertGetId([
            'form_id' => $form,
            'name' => '{"en":"EN form","pt":"EN form","ko":"EN form"}',
            'created_at' => '2023-10-28 11:12:14',
        ]);

        DB::table(config('zeus-bolt.table-prefix') . 'fields')->insertGetId([
            'section_id' => $section1,
            'name' => '{"en":"ko name","pt":"ko name","ko":"ko name"}',
            'type' => '\\LaraZeus\\Bolt\\Fields\\Classes\\TextInput',
            'options' => '{"dateType":"string","prefix":null,"suffix":null,"htmlId":"W22IaV","hint":{"text":null,"icon":null,"color":null},"is_required":false,"column_span_full":false,"visibility":{"active":false}}',
            'created_at' => '2023-10-28 11:13:25',
        ]);

        DB::table(config('zeus-bolt.table-prefix') . 'fields')->insertGetId([
            'section_id' => $section2,
            'name' => '{"en":"pt form","pt":"pt form","ko":"pt form"}',
            'type' => '\\LaraZeus\\Bolt\\Fields\\Classes\\TextInput',
            'options' => '{"dateType":"string","prefix":null,"suffix":null,"htmlId":"W22IaV","hint":{"text":null,"icon":null,"color":null},"is_required":false,"column_span_full":false,"visibility":{"active":false}}',
            'created_at' => '2023-10-28 11:12:40',
        ]);

        DB::table(config('zeus-bolt.table-prefix') . 'fields')->insertGetId([
            'section_id' => $section3,
            'name' => '{"en":"en name","pt":"en name","ko":"en name"}',
            'type' => '\\LaraZeus\\Bolt\\Fields\\Classes\\TextInput',
            'options' => '{"dateType":"string","prefix":null,"suffix":null,"htmlId":"yJ2wkp","hint":{"text":null,"icon":null,"color":null},"is_required":false,"column_span_full":false,"visibility":{"active":false}}',
            'created_at' => '2023-10-28 11:12:14',
        ]);

        $collection = DB::table(config('zeus-bolt.table-prefix') . 'collections')->insertGetId([
            'name' => 'yes or no',
            'values' => json_encode([
                [
                    'itemKey' => 'en',
                    'itemValue' => 'en',
                    'itemIsDefault' => false,
                ],
                [
                    'itemKey' => 'pt',
                    'itemValue' => 'pt',
                    'itemIsDefault' => false,
                ],
                [
                    'itemKey' => 'ko',
                    'itemValue' => 'ko',
                    'itemIsDefault' => false,
                ],
            ], JSON_THROW_ON_ERROR),
            'created_at' => now(),
        ]);

        $mainField = DB::table(config('zeus-bolt.table-prefix') . 'fields')->insertGetId([
            'section_id' => $section4,
            'name' => '{"en":"select lang","pt":"select lang","ko":"select lang"}',
            'type' => '\\LaraZeus\\Bolt\\Fields\\Classes\\Radio',
            'options' => '{"dataSource":"' . $collection . '","htmlId":"DZ80jG","hint":{"text":null,"icon":null,"color":null},"is_inline":false,"is_required":true,"column_span_full":false,"visibility":{"active":false}}',
            'created_at' => '2023-10-28 11:11:20',
        ]);

        DB::table(config('zeus-bolt.table-prefix') . 'sections')->where('id', $section1)->update([
            'options' => '{"visibility":{"active":true,"fieldID":"' . $mainField . '","values":"ko"}}',
        ]);

        DB::table(config('zeus-bolt.table-prefix') . 'sections')->where('id', $section2)->update([
            'options' => '{"visibility":{"active":true,"fieldID":"' . $mainField . '","values":"pt"}}',
        ]);

        DB::table(config('zeus-bolt.table-prefix') . 'sections')->where('id', $section3)->update([
            'options' => '{"visibility":{"active":true,"fieldID":"' . $mainField . '","values":"en"}}',
        ]);
    }
}
