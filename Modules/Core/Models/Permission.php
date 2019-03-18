<?php

namespace Modules\Core\Models;

class Permission
{
    //TODO remove Not use
    const INDEX_SCORE = 0;
    const ADD_SCORE = 1;
    const UPDATE_SCORE = 2;
    const DELETE_SCORE = 3;

    public static function getActionName($indexScore) {
        if ($indexScore == Permission::INDEX_SCORE)
            $str = 'Xem thông tin';
        elseif ($indexScore == Permission::ADD_SCORE)
            $str = "Thêm mới";
        elseif ($indexScore == Permission::UPDATE_SCORE)
            $str = "Chỉnh sửa";
        else
            $str = "Xóa";
        return $str;
    }

    public static function getActionScore($action) {
        $arrIndex = ["index", "show"];
        $arrAdd = ["create", "store"];
        $arrDelete = ["destroy"];
        $arrEdit = ["edit", "update"];

        if (in_array($action, $arrIndex))
            return Permission::INDEX_SCORE;
        elseif (in_array($action, $arrAdd))
            return Permission::ADD_SCORE;
        elseif (in_array($action, $arrDelete))
            return Permission::DELETE_SCORE;
        else
            return Permission::UPDATE_SCORE;
    }
    //TODO remove Not use

    public static function getRequestPermissionScore($controller, $action) {
        $listPermissions = Permission::getListPermissions();
        if (isset($listPermissions[$controller]["actions"][$action])) {
            // Default action is update
            $scorePermission = $listPermissions[$controller]['actions'][$action]['id'];
            return $scorePermission;
        }
        return null;
    }

    public static function getListPermissions()
    {
        return [
            'Modules\News\Http\Controllers\NewsCategoryController' => [
                'id' => 0,
                'actions' => [
                    "index" => [
                        "id" => 0,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 0,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 1,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 1,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 2,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 2,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 3,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý danh mục tin'
            ],
            'Modules\News\Http\Controllers\NewsPostController' => [
                'id' => 1,
                'actions' => [
                    "index" => [
                        "id" => 4,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 4,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 5,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 5,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 6,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 6,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 7,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý tin tức'
            ],
            'Modules\Insurance\Http\Controllers\CustomerTypeController' => [
                'id' => 2,
                'actions' => [
                    "index" => [
                        "id" => 8,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 8,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 9,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 9,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 10,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 10,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 11,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý loại khách hàng'
            ],
            'Modules\Insurance\Http\Controllers\CustomerController' => [
                'id' => 3,
                'actions' => [
                    "index" => [
                        "id" => 12,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 12,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 13,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 13,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 14,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 14,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 15,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý khách hàng'
            ],
            'Modules\Insurance\Http\Controllers\AgencyController' => [
                'id' => 4,
                'actions' => [
                    "index" => [
                        "id" => 16,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 16,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 17,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 17,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 18,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 18,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 19,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý đại lý bảo hiểm'
            ],
            'Modules\Insurance\Http\Controllers\CompanyController' => [
                'id' => 5,
                'actions' => [
                    "index" => [
                        "id" => 20,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 20,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 21,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 21,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 22,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 22,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 23,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý công ty bảo hiểm'
            ],
            'Modules\Insurance\Http\Controllers\InsuranceTypeController' => [
                'id' => 6,
                'actions' => [
                    "index" => [
                        "id" => 24,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 24,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 25,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 25,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 26,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 26,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 27,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý loại hình bảo hiểm'
            ],
            'Modules\Insurance\Http\Controllers\InsurancePriceController' => [
                'id' => 7,
                'actions' => [
                    "index" => [
                        "id" => 28,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 28,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 29,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 29,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 30,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 30,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 31,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý thuộc tính giá cho loại hình bảo hiểm'
            ],
            'Modules\Insurance\Http\Controllers\InsurancePriceTypeController' => [
                'id' => 8,
                'actions' => [
                    "index" => [
                        "id" => 32,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 32,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 33,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 33,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 34,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 34,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 35,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý loại giá cho loại hình bảo hiểm'
            ],
            'Modules\Insurance\Http\Controllers\BeneficiaryTypeController' => [
                'id' => 9,
                'actions' => [
                    "index" => [
                        "id" => 36,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 36,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 37,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 37,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 38,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 38,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 39,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý loại đối tượng hưởng bảo hiểm'
            ],
            'Modules\Insurance\Http\Controllers\BeneficiaryTypeAttributeController' => [
                'id' => 10,
                'actions' => [
                    "index" => [
                        "id" => 40,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 40,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 41,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 41,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 42,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 42,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 43,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý thuộc tính loại đối tượng bảo hiểm'
            ],
            'Modules\Insurance\Http\Controllers\ContractController' => [
                'id' => 11,
                'actions' => [
                    "index" => [
                        "id" => 44,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 44,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 45,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 45,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 46,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 46,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 47,
                        "name" => "Xóa"
                    ],
                    'confirmPayment' => [
                        'id' => 96,
                        'name' => 'Xác nhận thanh toán'
                    ],
                    'updatePayment' => [
                        'id' => 105,
                        'name' => 'Cập nhật thanh toán'
                    ],
                    'provideInsurance' => [
                        'id' => 102,
                        'name' => 'Cấp đơn bảo hiểm'
                    ],
                    'preview_contract'  => [
                        'id' => 102,
                        'name'  => 'Xem trước'
                    ]
                ],
                'name' => 'Quản lý hợp đồng'
            ],
            'Modules\Insurance\Http\Controllers\FormulaController' => [
                'id' => 12,
                'actions' => [
                    "index" => [
                        "id" => 48,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 48,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 49,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 49,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 50,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 50,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 51,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý công thức tính phí bảo hiểm'
            ],
            'Modules\Product\Http\Controllers\ProductCategoryController' => [
                'id' => 13,
                'actions' => [
                    "index" => [
                        "id" => 52,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 52,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 53,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 53,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 54,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 54,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 55,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý danh mục sản phẩm'
            ],
            'Modules\Product\Http\Controllers\ProductCategoryAttributeController' => [
                'id' => 14,
                'actions' => [
                    "index" => [
                        "id" => 56,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 56,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 57,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 57,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 58,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 58,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 59,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý thuộc tính của danh mục sản phẩm'
            ],
            'Modules\Product\Http\Controllers\ProductController' => [
                'id' => 15,
                'actions' => [
                    "index" => [
                        "id" => 60,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 60,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 61,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 61,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 62,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 62,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 63,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý sản phẩm'
            ],
            'Modules\Product\Http\Controllers\ProductPriceController' => [
                'id' => 16,
                'actions' => [
                    "index" => [
                        "id" => 64,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 64,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 65,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 65,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 66,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 66,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 67,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý giá cho sản phẩm'
            ],
            'Modules\Product\Http\Controllers\CommissionController' => [
                'id' => 17,
                'actions' => [
                    "index" => [
                        "id" => 68,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 68,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 69,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 69,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 70,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 70,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 71,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý hoa hồng'
            ],
            'Modules\Product\Http\Controllers\ProductAgencyCommissionController' => [
                'id' => 18,
                'actions' => [
                    "index" => [
                        "id" => 72,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 72,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 73,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 73,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 74,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 74,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 75,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý hoa hồng của Ebaohiem dành cho đại lý'
            ],
            'Modules\Product\Http\Controllers\CouponController' => [
                'id' => 19,
                'actions' => [
                    "index" => [
                        "id" => 76,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 76,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 77,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 77,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 78,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 78,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 79,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý mã giảm giá'
            ],
            'Modules\Product\Http\Controllers\CategoryClassController' => [
                'id' => 20,
                'actions' => [
                    "index" => [
                        "id" => 80,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 80,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 81,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 81,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 82,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 82,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 83,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý hạng sản phẩm'
            ],
            'Modules\Core\Http\Controllers\UserController' => [
                'id' => 21,
                'actions' => [
                    "index" => [
                        "id" => 84,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 84,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 85,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 85,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 86,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 86,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 87,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý người dùng'
            ],
            'Modules\Core\Http\Controllers\RoleController' => [
                'id' => 22,
                'actions' => [
                    "index" => [
                        "id" => 88,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 88,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 89,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 89,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 90,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 90,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 91,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý quyền'
            ],
            'Modules\Core\Http\Controllers\GroupController' => [
                'id' => 23,
                'actions' => [
                    "index" => [
                        "id" => 92,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 92,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 93,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 93,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 94,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 94,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 95,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý nhóm người dùng'
            ],
            'Modules\Insurance\Http\Controllers\QuotationController' => [
                'id' => 24,
                'actions' => [
                    "index" => [
                        "id" => 97,
                        "name" => "Xem"
                    ],
                    "show" => [
                        "id" => 97,
                        "name" => "Xem"
                    ],
                    "create" => [
                        "id" => 99,
                        "name" => "Thêm mới"
                    ],
                    "store" => [
                        "id" => 99,
                        "name" => "Thêm mới"
                    ],
                    "edit" => [
                        "id" => 100,
                        "name" => "Chỉnh sửa"
                    ],
                    "update" => [
                        "id" => 100,
                        "name" => "Chỉnh sửa"
                    ],
                    "destroy" => [
                        "id" => 101,
                        "name" => "Xóa"
                    ]
                ],
                'name' => 'Quản lý báo giá'
            ],
            'Modules\Core\Http\Controllers\SettingController' => [
                'id' => 25,
                'actions' => [
                    "index" => [
                        "id" => 103,
                        "name" => "Xem"
                    ],
                    "update" => [
                        "id" => 104,
                        "name" => "Cập nhật"
                    ]
                ],
                'name' => 'Thiết lập hệ thống'
            ],
            'Modules\Insurance\Http\Controllers\StatisticController' => [
                'id' => 26,
                'actions' => [
                    "revenue" => [
                        "id" => 105,
                        "name" => "Thống kê doanh thu"
                    ]
                ],
                'name' => 'Thống kê'
            ]
        ];
    }
}
