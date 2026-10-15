<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // group, key, value, type, label
            ['general', 'site_name',              'GuhangaAkazi',                                 'string', 'Website Name'],
            ['general', 'site_tagline_en',        'Business ideas, skills & opportunities',        'string', 'Tagline (EN)'],
            ['general', 'site_tagline_rw',        'Ibitekerezo by\'ubucuruzi, ubumenyi n\'amahirwe', 'string', 'Tagline (RW)'],
            ['general', 'site_logo',              '',                                             'image',  'Logo'],
            ['general', 'site_favicon',           '',                                             'image',  'Favicon'],

            ['contact', 'contact_email',          'info@guhangakazi.rw',                          'string', 'Contact Email'],
            ['contact', 'contact_phone',          '',                                             'string', 'Contact Phone'],
            ['contact', 'contact_address',        'Kigali, Rwanda',                               'string', 'Contact Address'],

            ['social',  'facebook_url',           '',                                             'string', 'Facebook URL'],
            ['social',  'twitter_url',            '',                                             'string', 'Twitter/X URL'],
            ['social',  'instagram_url',          '',                                             'string', 'Instagram URL'],
            ['social',  'youtube_url',            '',                                             'string', 'YouTube URL'],
            ['social',  'linkedin_url',           '',                                             'string', 'LinkedIn URL'],

            ['seo',     'seo_default_title_en',   'GuhangaAkazi - Business Ideas & Opportunities',   'string', 'Default Title (EN)'],
            ['seo',     'seo_default_title_rw',   'GuhangaAkazi - Ibitekerezo n\'Amahirwe',         'string', 'Default Title (RW)'],
            ['seo',     'seo_default_description_en', 'Discover business ideas, learn practical skills and find opportunities in Rwanda.', 'text', 'Default Meta Description (EN)'],
            ['seo',     'seo_default_description_rw', 'Menya ibitekerezo by\'ubucuruzi, wige ubumenyi n\'amahirwe mu Rwanda.',           'text', 'Default Meta Description (RW)'],

            ['analytics', 'google_analytics_id',          '', 'string', 'Google Analytics ID (G-XXXX)'],
            ['analytics', 'google_search_console_token',  '', 'string', 'Google Search Console Verification Token'],

            ['schema', 'organization_schema', '{"@context":"https://schema.org","@type":"Organization","name":"GuhangaAkazi","url":"","logo":""}', 'json', 'Organization JSON-LD'],

            ['content', 'comments_enabled', '1', 'boolean', 'Comments Enabled Globally'],

            ['pages', 'about_content_en',   '', 'text', 'About Page Content (EN)'],
            ['pages', 'about_content_rw',   '', 'text', 'About Page Content (RW)'],
            ['pages', 'privacy_content_en', '', 'text', 'Privacy Policy (EN)'],
            ['pages', 'privacy_content_rw', '', 'text', 'Privacy Policy (RW)'],
            ['pages', 'terms_content_en',   '', 'text', 'Terms of Use (EN)'],
            ['pages', 'terms_content_rw',   '', 'text', 'Terms of Use (RW)'],
            ['pages', 'footer_content_en',  '', 'text', 'Footer Content (EN)'],
            ['pages', 'footer_content_rw',  '', 'text', 'Footer Content (RW)'],
        ];

        foreach ($settings as [$group, $key, $value, $type, $label]) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group, 'type' => $type, 'label' => $label]
            );
        }

        $this->command->info('Settings seeded: ' . count($settings) . ' rows');
    }
}
