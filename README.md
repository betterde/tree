# Use guide

```
use Betterde\Tree\Generator;

$menus = [
    [
        'id' => 1,
        'parent_id' => 0,
        'label' => 'Dashboard',
        'link' => '/dashboard',
        'icon' => null,
        'roles' => 'Admin,'
    ],
    [
        'id' => 2,
        'parent_id' => 1,
        'label' => 'Fiance',
        'link' => '/dashboard/finace',
        'icon' => null,
        'roles' => 'Admin,Fiance'
    ],
    [
        'id' => 3,
        'parent_id' => 1,
        'label' => 'Operation',
        'link' => '/dashboard/operation',
        'icon' => null,
        'roles' => 'Admin,Operation'
    ],
];

$generator = new Generator();
$tree = $generator->make($menus, 'id', 'parent_id', 'sub_menus', 0);
```
# Generated result
```php
[
    [
        'id' => 1,
        'parent_id' => 0,
        'label' => 'Dashboard',
        'link' => '/dashboard',
        'icon' => null,
        'roles' => 'Admin,',
        'sub_menus' => [
            [
                'id' => 2,
                'parent_id' => 1,
                'label' => 'Fiance',
                'link' => '/dashboard/finace',
                'icon' => null,
                'roles' => 'Admin,Fiance'
            ],
            [
                'id' => 3,
                'parent_id' => 1,
                'label' => 'Operation',
                'link' => '/dashboard/operation',
                'icon' => null,
                'roles' => 'Admin,Operation'
            ]
        ]
    ]
];
```
