<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Bank;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\Country;
use App\Models\License;
use App\Models\Permission;
use App\Models\ProductCategory;
use App\Models\Software;
use App\Models\State;
use App\Models\User;
use App\Models\UserClient;
use App\Models\Wallet;
use App\Models\WalletAsset;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Nigeria',
                'code' => '234',
                'flag' => '🇳🇬',
                'iso2' => 'NG',
                'iso3' => 'NGA',
                'currency' => 'NGN',
                'status' => 'active',
            ],
        ];

        Country::insert($countries);

        $states = [
            [
                'name' => 'Borno',
                'status' => 'active',
                'country_id' => 1
            ],
            [
                'name' => 'Bauchi',
                'status' => 'active',
                'country_id' => 1
            ],
            [
                'name' => 'Yobe',
                'status' => 'active',
                'country_id' => 1
            ],
            [
                'name' => 'Jigawa',
                'status' => 'active',
                'country_id' => 1
            ],
            [
                'name' => 'Kano',
                'status' => 'active',
                'country_id' => 1
            ]
        ];

        State::insert($states);

        $cities = [
            [
                'name' => 'Maiduguri',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 1,
                'country_id' => 1
            ],
            [
                'name' => 'Baga',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 1,
                'country_id' => 1
            ],
            [
                'name' => 'Bama',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 1,
                'country_id' => 1
            ],
            [
                'name' => 'Damboa',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 1,
                'country_id' => 1
            ],
            [
                'name' => 'Bauchi',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 2,
                'country_id' => 1
            ],
            [
                'name' => 'Azare',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 2,
                'country_id' => 1
            ],
            [
                'name' => 'Misau',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 2,
                'country_id' => 1
            ],

            [
                'name' => 'Damaturu',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 3,
                'country_id' => 1
            ],
            [
                'name' => 'Patiskum',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 3,
                'country_id' => 1
            ],
            [
                'name' => 'Jigawa',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 4,
                'country_id' => 1
            ],
            [
                'name' => 'kano',
                'postal_code' => '600282',
                'status' => 'active',
                'state_id' => 5,
                'country_id' => 1
            ],
        ];

        City::insert($cities);

        $product_categories = [
            [
                'title' => 'General Items'
            ],
            [
                'title' => 'Home Appliance'
            ],
            [
                'title' => 'Accessories'
            ],
            [
                'title' => 'Electric and Electronics'
            ],
            [
                'title' => 'Medicine'
            ],
            [
                'title' => 'Kichen Wires'
            ],

            [
                'title' => 'Underwares'
            ],
            [
                'title' => 'Atampa and Less'
            ],
            [
                'title' => 'Toys and Games'
            ],
            [
                'title' => 'Shadda and Yadi'
            ],
            [
                'title' => 'Food Crops'
            ],
            [
                'title' => 'Building and Constructions'
            ],
            [
                'title' => 'Printers and Scanners'
            ],
            [
                'title' => 'Software'
            ],
            [
                'title' => 'Industrial and Scientific'
            ],
            [
                'title' => 'Arts and Crafts'
            ],
            [
                'title' => 'Jewelry and accessories'
            ],
            [
                'title' => 'Groceries'
            ],
            [
                'title' => 'Baby Products'
            ],
            [
                'title' => 'Garden and Outdoor'
            ],
            [
                'title' => 'Office Supplies'
            ],
            [
                'title' => 'Health and Wellness'
            ],
            [
                'title' => 'Pet Supplies'
            ],
            [
                'title' => 'Books'
            ],
            [
                'title' => 'Automotive'
            ],
            [
                'title' => 'Sports and Outdoors'
            ],
            [
                'title' => 'Beauty and Personal Care'
            ],
            [
                'title' => 'Home and Kitchen'
            ],
        ];

        ProductCategory::insert($product_categories);

        $client_categories = [
            [
                'title' => 'Food and Beverage',
                'status' => 'active',
                'description' => 'Food and Beverage covers the production, distribution, and sale of food products and beverages, including restaurants, catering services, and food processing industries.',
            ],
            [
                'title' => 'Agriculture',
                'status' => 'suspended',
                'description' => 'Agriculture involves the cultivation of plants and the rearing of animals for food, fiber, medicinal plants, and other products used to sustain and enhance human life',
            ],
            [
                'title' => 'Beauty and Wellness',
                'status' => 'active',
                'description' => 'Beauty and Wellness covers a range of services and products that promote physical and mental health, including skincare, haircare, fitness, and holistic wellness practices.',
            ],
            [
                'title' => 'Clothing and Accessories',
                'status' => 'active',
                'description' => 'Clothing and Accessories encompass the design, production, and sale of apparel and accessories such as shoes, bags, and jewelry that reflect personal style and cultural trends.',
            ],
            [
                'title' => 'Electric and Electronics',
                'status' => 'active',
                'description' => 'Electronics involve the manufacturing, distribution, and sale of devices such as smartphones, computers, and home appliances, along with related software and accessories.',
            ],
            [
                'title' => 'Home and Garden',
                'status' => 'active',
                'description' => 'Home and Garden includes businesses that sell products and services related to home improvement, gardening, and interior design, helping homeowners create functional and aesthetically pleasing living spaces.',
            ],
            [
                'title' => 'Industrial Equipment',
                'status' => 'active',
                'description' => 'Industrial Equipment involves the manufacturing and sale of machinery and equipment used in various industries such as construction, manufacturing, and mining to improve productivity and efficiency.',
            ],
            [
                'title' => 'Jewelry and Watches',
                'status' => 'active',
                'description' => 'Jewelry and Watches include the design, creation, and sale of fine jewelry and timepieces, often featuring precious metals and gemstones, catering to both fashion and luxury markets.',
            ],
            [
                'title' => 'Retail',
                'status' => 'active',
                'description' => 'Retail involves the sale of goods and services directly to consumers through various channels such as brick-and-mortar stores, online platforms, and catalogs.',
            ],
            [
                'title' => 'Sports and Fitness',
                'status' => 'active',
                'description' => 'Sports and Fitness cover products, services, and facilities that promote physical activity and healthy living, including sports equipment, fitness centers, and recreational sports programs',
            ],
            [
                'title' => 'Transportation',
                'status' => 'suspended',
                'description' => 'Transportation involves the movement of goods and people, encompassing industries such as automotive, aviation, shipping, and public transit, which are essential for global trade and mobility.',
            ],
            [
                'title' => 'Web Development',
                'status' => 'suspended',
                'description' => 'Web developers create functional, user-friendly websites and web applications. They may write code, develop and test new applications, or monitor site performance and traffic. Front-end developers focus on the user-facing side of their work, while back-end developers make websites functional and secure',
            ],
            [
                'title' => 'Utilities',
                'status' => 'suspended',
                'description' => 'Utilities provide essential services such as water, electricity, and gas to households and businesses, ensuring the infrastructure is in place to support daily living and economic activities',
            ],
            [
                'title' => 'Wholesale',
                'status' => 'active',
                'description' => 'Wholesale businesses sell goods in large quantities at lower prices, typically to retailers, who then sell them to the end consumers. This industry plays a key role in the supply chain',
            ],
            [
                'title' => 'Other',
                'status' => 'active',
                'description' => 'The "Other" category includes businesses that do not fit into the predefined categories, encompassing a wide range of unique and niche industries.',
            ],
        ];

        ClientCategory::insert($client_categories);

        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Ali Mustapha Shettima',
            'first_name' => 'Ali',
            'surname' => 'Mustapha',
            'last_name' => 'shettima',
            'phone_number' => '08165141519',
            'country_id' => 1,
            'state_id' => 1,
            'city_id' => 1,
            'bio' => '<hr><b>Code your dreams into reality</b>',
            'client_id' => 1,
            'language' => 'English',
            'visibility' => 'public',
            'email' => 'abituho7s@mozmail.com',
            'profile_photo_path' => 'profile-photos/WR4viAixuYbZnhcPacSugVcjhx0iBZ3FViLbPq5Q.jpg'
        ]);
        $key = system_generate_new_api_key();
        $now = now();
        $hash = write($key . 'ALmax' . '1' . 'Ali Mustapha Shettima' . '1');
        $certificate = <<<EOT
            -----BEGIN CERTIFICATE-----
            Type:: lifetime
            Active:: $now
            Expire:: --/--/----
            Price:: 1000000000.00
            Payment:: system
            Owner:: 'Ali Mustapha Shettima'
            Software:: ALmax
            Software Key:: 247365#ALmax
            License Key:: $key
            ----------------------------
            Hash:: $hash
            -----END CERTIFICATE-----
            EOT;
        Software::create([
            'title' => 'ALmax',
            'description' => 'Code your dreams into reality.',
            'sale_price' => 1000000000,
            'status' => 'approved',
            'file_path' => '/',
            'key' => '247365#ALmax',
            'developer_id' => 1
        ]);
        Client::create([
            'name' => 'ALmax Technology',
            'logo' => 'build/assets/almax-preview.png',
            'email' => 'alimustaphashettima@gmail.com',
            'tagline' => 'where dreams become reality and the power of technology knows no boundaries.',
            'telephone' => '08166636567',
            'country_id' => 1,
            'state_id' => 1,
            'city_id' => 1,
            'vision' => "Our vision is to be the leading provider of technology solutions, recognized for our exceptional quality, innovation, and impact. We envision a future where technology is accessible to all, empowering individuals to unlock their full potential, businesses to thrive in the digital economy, and communities to flourish in the age of digital transformation. Through our relentless pursuit of excellence and our commitment to creating meaningful change, we strive to shape a brighter future for Africa, where technology becomes an enabler of progress and prosperity.",
            'mission' => "ALmax's mission is to empower individuals, businesses, and communities through innovative technological solutions and services. We strive to bridge the digital divide, foster economic growth, and create opportunities for sustainable development. By leveraging our expertise cutting-edge technologies, we aim to be a catalyst for positive change and enable our clients to achieve their goals and aspirations.",
            'description' => 'where dreams become reality and the power of technology knows no boundaries',
            'is_registered' => true,
            'is_verified' => true,
            'status' => 'active',
            'user_id' => 1,
            'category_id' => 15,
        ]);
        UserClient::create([
            'user_id' => 1,
            'is_staff' => true,
            'client_id' => 1,
        ]);
        License::create([
            'certificate' => $certificate,
            'user_id' => 1,
            'client_id' => 1,
            'software_id' => 1,
            'key' => $key,
            'type' => 'lifetime',
            'activated_at' => now(),
        ]);

        $Banks = [
            [
                'title' => 'Access Bank',
            ],
            [
                'title' => 'Zenith Bank',
            ],
            [
                'title' => 'First Bank',
            ],
            [
                'title' => 'Wema Bank',
            ],
            [
                'title' => 'UBA Bank',
            ],
            [
                'title' => 'GT Bank',
            ],
            [
                'title' => 'Opay',
            ],
            [
                'title' => 'Palmpay',
            ],
            [
                'title' => 'Paystack',
            ],
            [
                'title' => 'Flutterwave',
            ],

        ];

        Bank::insert($Banks);

        $permissions = [
            [
                'title' => 'Business Settings Access',
                'label' => 'business_settings',
                'description' => 'This Give Access to user to have Management on his or her menu it is required to have access to other settings such as Staff management, business setting and more.',
                'status' => 'active',
            ],
            [
                'title' => 'View Staffs',
                'label' => 'view_staff',
                'description' => 'This Allow user to view Client Staffs profile.',
                'status' => 'active',
            ],
            [
                'title' => 'Staff Role Management',
                'label' => 'role_management',
                'description' => 'This Allow user to assign and remove role from staffs of a client.',
                'status' => 'active',
            ],
            [
                'title' => 'Staff Management',
                'label' => 'staff_management',
                'description' => 'This Allow user to manage Client staff, user can send white papers or approve white paper to empower staff and also remove staff from a client it also include role management.',
                'status' => 'active',
            ],
            [
                'title' => 'Dashboard View',
                'label' => 'dashboad_view',
                'description' => 'Allow user to view client dashboad. this dashboard is a client summary board.',
                'status' => 'active',
            ],
            [
                'title' => 'Business Profile Access',
                'label' => 'business_access',
                'description' => 'This allow user to activate Client and also allow user to update Client info such as logo, name and more.',
                'status' => 'active',
            ],
            [
                'title' => 'Products Menu Access',
                'label' => 'product_access',
                'description' => 'This Allow user to have access to Product Menu and also view them with details including Varient and addons',
                'status' => 'active',
            ],
            [
                'title' => 'Manage Product',
                'label' => 'product_management',
                'description' => 'Manage Client Products and Product Varient including creation, modification, and deactivation.',
                'status' => 'active',
            ],
            [
                'title' => 'Task Management',
                'label' => 'task_management',
                'description' => 'Allow user to Manage Client ask include assign task to other staffs of that client.',
                'status' => 'active',
            ],
            [
                'title' => 'Report management',
                'label' => 'report_generation',
                'description' => 'Generate reports based on various criteria and export them in different formats.',
                'status' => 'active',
            ],
            [
                'title' => 'Manage Product Reservation',
                'label' => 'manage_product_resevation',
                'description' => 'This allow user to manage product reservation of a client.',
                'status' => 'active',
            ],
            [
                'title' => 'Customer Support',
                'label' => 'customer_support',
                'description' => 'Provide support to customers including handling inquiries and resolving issues.',
                'status' => 'active',
            ],
            [
                'title' => 'Marketing Management',
                'label' => 'marketing_management',
                'description' => 'Manage marketing campaigns, track performance, and analyze results.',
                'status' => 'active',
            ],
            [
                'title' => 'Content Management',
                'label' => 'content_management',
                'description' => 'Create, edit, and delete content for the platform including articles, blogs, and announcements.',
                'status' => 'active',
            ],
            [
                'title' => 'APU Access',
                'label' => 'api_access',
                'description' => 'Access and manage API keys and integrations with external services.',
                'status' => 'active',
            ],
            [
                'title' => 'Document Management',
                'label' => 'document_management',
                'description' => 'Manage documents including storage, retrieval, and version control.',
                'status' => 'active',
            ],
            [
                'title' => 'Event Access',
                'label' => 'event_access',
                'description' => 'This allow user to access event menu and also view them with details',
                'status' => 'active',
            ],
            [
                'title' => 'Access Client Wallet',
                'label' => 'client_wallet_access',
                'description' => 'This allow user to access client wallet menu and also view them with details',
                'status' => 'active',
            ],
            [
                'title' => 'Sales Access',
                'label' => 'sales_access',
                'description' => 'This allow user to access sales menu and also view them with details',
                'status' => 'active',
            ],
            [
                'title' => 'Manage Sales',
                'label' => 'manage_sales',
                'description' => 'This allow user to manage sales of a client.',
                'status' => 'active',
            ],

        ];

        Permission::insert($permissions);

        Wallet::create([
            'user_id' => null,
            'client_id' => 1,
            'label' => 'System Wallet',
            'address' => '0xFF1RkuxfXxYnyZviSOPQBTxltJc1Yx4xyY',
            'balance' => 1000000,
            'pin' => null,
            'status' => 'active',
            'type' => 'client', # client or user
        ]);
        $assets = [
            [
                'label' => 'Naira',
                'sign' => 'NGN',
                'symbol' => '₦',
                'type' => 'currency',
                'is_verified' => true,
                'value' => 0,
            ],
            [
                'label' => 'Dollar',
                'sign' => 'USD',
                'symbol' => '$',
                'type' => 'currency',
                'is_verified' => true,
                'value' => 0,
            ],
        ];
        Asset::insert($assets);
        WalletAsset::create([
            'wallet_id' => 1,
            'asset_id' => 1,
            'amount' => 0,
        ]);
        WalletAsset::create([
            'wallet_id' => 1,
            'asset_id' => 2,
            'amount' => 0,
        ]);
    }
}
