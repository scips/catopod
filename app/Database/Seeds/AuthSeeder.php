<?php
/**
 * Class PermissionSeeder
 * Inserts permissions
 *
 * @copyright  2020 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthSeeder extends Seeder
{
    protected $groups = [
        [
            'name' => 'superadmin',
            'description' =>
                'Somebody who has access to all the castopod instance features',
        ],
        [
            'name' => 'podcast_admin',
            'description' =>
                'Somebody who has access to all the features within a given podcast',
        ],
    ];

    /** Build permissions array as a list of:
     *
     * ```
     * context => [
     *      [action, description],
     *      [action, description],
     *      ...
     * ]
     * ```
     */
    protected $permissions = [
        'users' => [
            [
                'name' => 'create',
                'description' => 'Create a user',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'list',
                'description' => 'List all users',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'manage_authorizations',
                'description' => 'Add or remove roles/permissions to a user',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'manage_bans',
                'description' => 'Ban / unban a user',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'force_pass_reset',
                'description' =>
                    'Force a user to update his password upon next login',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'delete',
                'description' =>
                    'Delete user without removing him from database',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'delete_permanently',
                'description' =>
                    'Delete all occurrences of a user from the database',
                'has_permission' => ['superadmin'],
            ],
        ],
        'podcasts' => [
            [
                'name' => 'create',
                'description' => 'Add a new podcast',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'list',
                'description' => 'List all podcasts and their episodes',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'view',
                'description' => 'View any podcast',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'edit',
                'description' => 'Edit any podcast',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'manage_contributors',
                'description' => 'Add / remove contributors to a podcast',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'manage_publication',
                'description' => 'Publish / unpublish a podcast',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'delete',
                'description' =>
                    'Delete a podcast without removing it from database',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'delete_permanently',
                'description' => 'Delete any podcast from the database',
                'has_permission' => ['superadmin'],
            ],
        ],
        'episodes' => [
            [
                'name' => 'list',
                'description' => 'List all episodes of any podcast',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'create',
                'description' => 'Add a new episode to any podcast',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'edit',
                'description' => 'Edit any podcast episode',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'manage_publications',
                'description' => 'Publish / unpublish any podcast episode',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'delete',
                'description' =>
                    'Delete any podcast episode without removing it from database',
                'has_permission' => ['superadmin'],
            ],
            [
                'name' => 'delete_permanently',
                'description' => 'Delete any podcast episode from database',
                'has_permission' => ['superadmin'],
            ],
        ],
        'podcast' => [
            [
                'name' => 'view',
                'description' => 'View a podcast',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'edit',
                'description' => 'Edit a podcast',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'delete',
                'description' =>
                    'Delete a podcast without removing it from the database',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'delete_permanently',
                'description' => 'Delete a podcast from the database',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'manage_contributors',
                'description' =>
                    'Add / remove contributors to a podcast and edit their roles',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'manage_publication',
                'description' => 'Publish / unpublish a podcast',
                'has_permission' => ['podcast_admin'],
            ],
        ],
        'podcast_episodes' => [
            [
                'name' => 'list',
                'description' => 'List all episodes of a podcast',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'create',
                'description' => 'Add new episodes for a podcast',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'edit',
                'description' => 'Edit an episode of a podcast',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'delete',
                'description' =>
                    'Delete an episode of a podcast without removing it from the database',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'delete_permanently',
                'description' =>
                    'Delete all occurrences of an episode of a podcast from the database',
                'has_permission' => ['podcast_admin'],
            ],
            [
                'name' => 'manage_publications',
                'description' => 'Publish / unpublish episodes of a podcast',
                'has_permission' => ['podcast_admin'],
            ],
        ],
    ];

    static function getGroupIdByName($name, $data_groups)
    {
        foreach ($data_groups as $group) {
            if ($group['name'] === $name) {
                return $group['id'];
            }
        }
        return null;
    }

    public function run()
    {
        $group_id = 0;
        $data_groups = [];
        foreach ($this->groups as $group) {
            array_push($data_groups, [
                'id' => ++$group_id,
                'name' => $group['name'],
                'description' => $group['description'],
            ]);
        }

        // Map permissions to a format the `auth_permissions` table expects
        $data_permissions = [];
        $data_groups_permissions = [];
        $permission_id = 0;
        foreach ($this->permissions as $context => $actions) {
            foreach ($actions as $action) {
                array_push($data_permissions, [
                    'id' => ++$permission_id,
                    'name' => $context . '-' . $action['name'],
                    'description' => $action['description'],
                ]);

                foreach ($action['has_permission'] as $role) {
                    // link permission to specified groups
                    array_push($data_groups_permissions, [
                        'group_id' => $this->getGroupIdByName(
                            $role,
                            $data_groups
                        ),
                        'permission_id' => $permission_id,
                    ]);
                }
            }
        }

        $this->db->table('auth_permissions')->insertBatch($data_permissions);
        $this->db->table('auth_groups')->insertBatch($data_groups);
        $this->db
            ->table('auth_groups_permissions')
            ->insertBatch($data_groups_permissions);
    }
}
