<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Eloquent::unguard();

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Truncate all old roles and permissions
        DB::table(config('permission.table_names.model_has_permissions'))->truncate();
        DB::table(config('permission.table_names.model_has_roles'))->truncate();
        DB::table(config('permission.table_names.roles'))->truncate();
        DB::table(config('permission.table_names.permissions'))->truncate();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        /** Rollen und Rechte nach Dokument  https://digitalbynature.atlassian.net/browse/SMMVDB-3 */
        $admin = \Spatie\Permission\Models\Role::create(['name' => 'Administrator']);
        $sparkasse = \Spatie\Permission\Models\Role::create(['name' => 'Sparkasse']);

        $rechte_matrix = [
            "Administrator" => [],
            "Sparkasse" => [],
        ];

        /** Rechte Hauptnavigation */
        $this->generate_menu_matrix($rechte_matrix);

        /** Rechte aus "Hauptnavigation: Startseite */
        $this->generate_home_dashboard_right_matrix($rechte_matrix);

        /** Rechte aus "Hauptnavigation: Startseite */
        $this->generate_customer_matrix($rechte_matrix);


        /** Rechte aus "Hauptnavigation: Startseite */
        $this->generate_user_matrix($rechte_matrix);

        foreach ($rechte_matrix as $role => $permissions) {
            \Spatie\Permission\Models\Role::findByName($role)->syncPermissions($permissions);
        }
    }

    /**
     * @param array $rechte_matrix
     */
    private function generate_menu_matrix(array &$rechte_matrix): void
    {
        $main_menu_home = \Spatie\Permission\Models\Permission::create(['name' => 'main_menu_home']);
        $rechte_matrix["Administrator"][] = $main_menu_home;
        $rechte_matrix["Sparkasse"][] = $main_menu_home;

        $main_menu_customers = \Spatie\Permission\Models\Permission::create(['name' => 'main_menu_customers']);
        $rechte_matrix["Administrator"][] = $main_menu_customers;
        $rechte_matrix["Sparkasse"][] = $main_menu_customers;

        $main_menu_contacts = \Spatie\Permission\Models\Permission::create(['name' => 'main_menu_contacts']);
        $rechte_matrix["Administrator"][] = $main_menu_contacts;

        $main_menu_persons = \Spatie\Permission\Models\Permission::create(['name' => 'main_menu_persons']);
        $rechte_matrix["Administrator"][] = $main_menu_persons;

        $main_menu_measures = \Spatie\Permission\Models\Permission::create(['name' => 'main_menu_measures']);
        $rechte_matrix["Administrator"][] = $main_menu_measures;

        $main_menu_evaluation = \Spatie\Permission\Models\Permission::create(['name' => 'main_menu_evaluation']);
        $rechte_matrix["Administrator"][] = $main_menu_evaluation;

    }

    /**
     * @param array $rechte_matrix
     */
    private function generate_home_dashboard_right_matrix(array &$rechte_matrix): void
    {
        $home_see_overview = \Spatie\Permission\Models\Permission::create(['name' => 'home_see_overview']);
        $rechte_matrix["Administrator"][] = $home_see_overview;
        $rechte_matrix["Sparkasse"][] = $home_see_overview;

        $home_view_search = \Spatie\Permission\Models\Permission::create(['name' => 'home_view_search']);
        $rechte_matrix["Administrator"][] = $home_view_search;

        $home_dashboard = \Spatie\Permission\Models\Permission::create(['name' => 'home_dashboard']);
        $rechte_matrix["Administrator"][] = $home_dashboard;
        $rechte_matrix["Sparkasse"][] = $home_dashboard;

        $home_dashboard_customers = \Spatie\Permission\Models\Permission::create(['name' => 'home_dashboard_customers']);
        $rechte_matrix["Administrator"][] = $home_dashboard_customers;

        $home_dashboard_contacts = \Spatie\Permission\Models\Permission::create(['name' => 'home_dashboard_contacts']);
        $rechte_matrix["Administrator"][] = $home_dashboard_contacts;


        $home_dashboard_measures = \Spatie\Permission\Models\Permission::create(['name' => 'home_dashboard_measures']);
        $rechte_matrix["Administrator"][] = $home_dashboard_measures;
        $rechte_matrix["Sparkasse"][] = $home_dashboard_measures;

        $home_dashboard_measures = \Spatie\Permission\Models\Permission::create(['name' => 'home_dashboard_measures_all_customer']);
        $rechte_matrix["Administrator"][] = $home_dashboard_measures;

        $home_dashboard_measures = \Spatie\Permission\Models\Permission::create(['name' => 'home_dashboard_measures_customer']);
        $rechte_matrix["Sparkasse"][] = $home_dashboard_measures;

        $home_dashboard_links = \Spatie\Permission\Models\Permission::create(['name' => 'home_dashboard_links']);
        $rechte_matrix["Sparkasse"][] = $home_dashboard_links;

        $home_dashboard_annual_overview = \Spatie\Permission\Models\Permission::create(['name' => 'home_dashboard_annual_overview']);
        $rechte_matrix["Administrator"][] = $home_dashboard_annual_overview;

        $home_dashboard_chart_customer = \Spatie\Permission\Models\Permission::create(['name' => 'home_dashboard_chart_customer']);
        $rechte_matrix["Administrator"][] = $home_dashboard_chart_customer;


    }

    /**
     * @param array $rechte_matrix
     */
    private function generate_customer_matrix(array &$rechte_matrix): void
    {
        $customer_budget_create = \Spatie\Permission\Models\Permission::create(['name' => 'customer_budget_create']);
        $rechte_matrix["Administrator"][] = $customer_budget_create;

        $customer_budget_edit = \Spatie\Permission\Models\Permission::create(['name' => 'customer_budget_edit']);
        $rechte_matrix["Administrator"][] = $customer_budget_edit;

        $customer_budget_delete = \Spatie\Permission\Models\Permission::create(['name' => 'customer_budget_delete']);
        $rechte_matrix["Administrator"][] = $customer_budget_delete;

        $customer_budget_assets_create = \Spatie\Permission\Models\Permission::create(['name' => 'customer_budget_assets_create']);
        $rechte_matrix["Administrator"][] = $customer_budget_assets_create;

        $customer_budget_assets_edit = \Spatie\Permission\Models\Permission::create(['name' => 'customer_budget_assets_edit']);
        $rechte_matrix["Administrator"][] = $customer_budget_assets_edit;

        $customer_budget_assets_delete = \Spatie\Permission\Models\Permission::create(['name' => 'customer_budget_assets_delete']);
        $rechte_matrix["Administrator"][] = $customer_budget_assets_delete;

        $customer_budget_assets_delete = \Spatie\Permission\Models\Permission::create(['name' => 'customer_import']);
        $rechte_matrix["Administrator"][] = $customer_budget_assets_delete;
    }

    private function generate_user_matrix(array &$rechte_matrix): void
    {
        $user_impersonate = \Spatie\Permission\Models\Permission::create(['name' => 'user_impersonate']);
        $rechte_matrix["Administrator"][] = $user_impersonate;

        $user_release = \Spatie\Permission\Models\Permission::create(['name' => 'user_release']);
        $rechte_matrix["Administrator"][] = $user_release;

        $user_delete = \Spatie\Permission\Models\Permission::create(['name' => 'user_delete']);
        $rechte_matrix["Administrator"][] = $user_delete;
    }
}
