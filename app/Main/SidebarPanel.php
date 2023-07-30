<?php

namespace App\Main;

class SidebarPanel
{
    public static function elements()
    {
        return [
            'title' => 'Elements',
            'items' => [
                [
                    'elements_avatar' => [
                        'title' => 'Avatar',
                        'route_name' => 'elements/avatar'
                    ],
                    'elements_alert' => [
                        'title' => 'Alert',
                        'route_name' => 'elements/alert'
                    ],
                    'elements_button' => [
                        'title' => 'Button',
                        'route_name' => 'elements/button'
                    ],
                    'elements_button_group' => [
                        'title' => 'Button Group',
                        'route_name' => 'elements/button-group'
                    ],
                    'elements_badge' => [
                        'title' => 'Badge',
                        'route_name' => 'elements/badge'
                    ],
                    'elements_breadcrumb' => [
                        'title' => 'Breadcrumb',
                        'route_name' => 'elements/breadcrumb'
                    ],
                    'elements_card' => [
                        'title' => 'Card',
                        'route_name' => 'elements/card'
                    ],
                    'elements_divider' => [
                        'title' => 'Divider',
                        'route_name' => 'elements/divider'
                    ],
                    'elements_mask' => [
                        'title' => 'Mask',
                        'route_name' => 'elements/mask'
                    ],
                    'elements_progress' => [
                        'title' => 'Progress',
                        'route_name' => 'elements/progress'
                    ],
                    'elements_skeleton' => [
                        'title' => 'Skeleton',
                        'route_name' => 'elements/skeleton'
                    ],
                    'elements_spinner' => [
                        'title' => 'Spinner',
                        'route_name' => 'elements/spinner'
                    ],
                    'elements_tag' => [
                        'title' => 'Tag',
                        'route_name' => 'elements/tag'
                    ],
                    'elements_tooltip' => [
                        'title' => 'Tooltip',
                        'route_name' => 'elements/tooltip'
                    ],
                ],
                [
                    'elements_forms' => [
                        'title' => 'Forms',
                        'route_name' => 'forms/input-text'
                    ],
                    'elements_typography' => [
                        'title' => 'Typography',
                        'route_name' => 'elements/typography'
                    ],
                ]
            ]
        ];
    }

    public static function components()
    {
        return [
            'title' => 'Components',
            'items' => [
                [
                    'components_accordion' => [
                        'title' => 'Accordion',
                        'route_name' => 'components/accordion'
                    ],
                    'components_collapse' => [
                        'title' => 'Collapse',
                        'route_name' => 'components/collapse'
                    ],
                    'components_tab' => [
                        'title' => 'Tab',
                        'route_name' => 'components/tab'
                    ],
                    'components_dropdown' => [
                        'title' => 'Dropdown',
                        'route_name' => 'components/dropdown'
                    ],
                    'components_popover' => [
                        'title' => 'Popover',
                        'route_name' => 'components/popover'
                    ],
                    'components_modal' => [
                        'title' => 'Modal',
                        'route_name' => 'components/modal'
                    ],
                    'components_drawer' => [
                        'title' => 'Drawer',
                        'route_name' => 'components/drawer'
                    ],
                    'components_steps' => [
                        'title' => 'Steps',
                        'route_name' => 'components/steps'
                    ],
                    'components_timeline' => [
                        'title' => 'Timeline',
                        'route_name' => 'components/timeline'
                    ],
                    'components_pagination' => [
                        'title' => 'Pagination',
                        'route_name' => 'components/pagination'
                    ],
                    'components_menu_list' => [
                        'title' => 'Menu List',
                        'route_name' => 'components/menu-list'
                    ],
                    'components_treeview' => [
                        'title' => 'Treeview',
                        'route_name' => 'components/treeview'
                    ],

                ],
                [
                    'components_table' => [
                        'title' => 'Table',
                        'route_name' => 'components/table'
                    ],

                    'components_table_advanced' => [
                        'title' => 'Table Advanced',
                        'route_name' => 'components/table-advanced'
                    ],

                    'components_table_gridjs' => [
                        'title' => 'Table Gridjs',
                        'route_name' => 'components/gridjs'
                    ],
                ],
                [
                    'components_apexchart' => [
                        'title' => 'Apexcharts',
                        'route_name' => 'components/apexchart'
                    ],

                    'components_carousel' => [
                        'title' => 'Carousel',
                        'route_name' => 'components/carousel'
                    ],

                    'components_notification' => [
                        'title' => 'Notification',
                        'route_name' => 'components/notification'
                    ],
                ],
                [
                    'components_extension_clipboard' => [
                        'title' => 'Clipboard',
                        'route_name' => 'components/extension-clipboard'
                    ],
                    'components_extension_persist' => [
                        'title' => 'Persist',
                        'route_name' => 'components/extension-persist'
                    ],
                    'components_extension_monochrome' => [
                        'title' => 'Monochrome Mode',
                        'route_name' => 'components/extension-monochrome'
                    ],
                ],
            ]
        ];
    }

    public static function forms()
    {
        return [
            'title' => 'Forms',
            'items' => [
                [
                    'forms_layout_v1' => [
                        'title' => 'Form Layout v1',
                        'route_name' => 'forms/layout-v1'
                    ],
                    'forms_layout_v2' => [
                        'title' => 'Form Layout v2',
                        'route_name' => 'forms/layout-v2'
                    ],
                    'forms_layout_v3' => [
                        'title' => 'Form Layout v3',
                        'route_name' => 'forms/layout-v3'
                    ],
                    'forms_layout_v4' => [
                        'title' => 'Form Layout v4',
                        'route_name' => 'forms/layout-v4'
                    ],
                    'forms_layout_v5' => [
                        'title' => 'Form Layout v5',
                        'route_name' => 'forms/layout-v5'
                    ],
                ],
                [
                    'forms_input_text' => [
                        'title' => 'Input text',
                        'route_name' => 'forms/input-text'
                    ],
                    'forms_input_group' => [
                        'title' => 'Input group',
                        'route_name' => 'forms/input-group'
                    ],
                    'forms_input_mask' => [
                        'title' => 'Input mask',
                        'route_name' => 'forms/input-mask'
                    ],
                    'forms_checkbox' => [
                        'title' => 'Checkbox',
                        'route_name' => 'forms/checkbox'
                    ],
                    'forms_radio' => [
                        'title' => 'Radio',
                        'route_name' => 'forms/radio'
                    ],
                    'forms_switch' => [
                        'title' => 'Switch',
                        'route_name' => 'forms/switch'
                    ],
                    'forms_select' => [
                        'title' => 'Select',
                        'route_name' => 'forms/select'
                    ],
                    'forms_tom_select' => [
                        'title' => 'Tom select',
                        'route_name' => 'forms/tom-select'
                    ],
                    'forms_textarea' => [
                        'title' => 'Textarea',
                        'route_name' => 'forms/textarea'
                    ],
                    'forms_range' => [
                        'title' => 'Range',
                        'route_name' => 'forms/range'
                    ],
                    'forms_datepicker' => [
                        'title' => 'Datepicker',
                        'route_name' => 'forms/datepicker'
                    ],
                    'forms_timepicker' => [
                        'title' => 'Timepicker',
                        'route_name' => 'forms/timepicker'
                    ],
                    'forms_datetimepicker' => [
                        'title' => 'Datetimepicker',
                        'route_name' => 'forms/datetimepicker'
                    ],
                    'forms_text_editor' => [
                        'title' => 'Text editor',
                        'route_name' => 'forms/text-editor'
                    ],
                    'forms_upload' => [
                        'title' => 'Form upload',
                        'route_name' => 'forms/upload'
                    ],
                    'forms_validation' => [
                        'title' => 'Form Validation',
                        'route_name' => 'forms/validation'
                    ],
                ]
            ]
        ];
    }

    public static function layouts()
    {
        return [
            'title' => 'Layouts',
            'items' => []
        ];
    }

    public static function apps()
    {
        return [
            'title' => 'Tasks',
            'items' => [
                [
                    'apps_chat' => [
                        'title' => 'Chat App',
                        'route_name' => 'apps/chat'
                    ],
                    'apps_kanban' => [
                        'title' => 'Kanban Board',
                        'route_name' => 'kanban'
                    ],
                    'apps_filemanager' => [
                        'title' => 'File Manager',
                        'route_name' => 'apps/filemanager'
                    ],
                    'apps_mail' => [
                        'title' => 'Mail App',
                        'route_name' => 'apps/mail'
                    ],
                    'apps_todo' => [
                        'title' => 'Todo App',
                        'route_name' => 'tasks'
                    ],
                ],
                [
                    'apps_nft_1' => [
                        'title' => 'NFT Apps v1',
                        'route_name' => 'apps/nft1'
                    ],
                    'apps_nft_2' => [
                        'title' => 'NFT Apps v2',
                        'route_name' => 'apps/nft2'
                    ],
                    'apps_pos' => [
                        'title' => 'POS System',
                        'route_name' => 'apps/pos'
                    ],
                    'apps_travel' => [
                        'title' => 'Travel App',
                        'route_name' => 'apps/travel'
                    ]
                ],
            ]
        ];
    }

    public static function dashboards()
    {
        return [
            'title' => 'Projects',
            'items' => []
        ];
    }

    public static function all()
    {
        return [self::dashboards(),self::apps(), self::layouts(), self::forms(), self::components(), self::elements()];
    }
}
