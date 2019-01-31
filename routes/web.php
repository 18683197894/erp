<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['user']],function(){
	//主页框架
	Route::get('/','Sys\IndexController@index');
	//个人控制台
	Route::get('/index/welcome-one','Sys\IndexController@welcome_one');
	//个人资料,密码修改
	Route::get('/user/personal','Sys\UserController@personal');
	Route::any('/user/personal-password','Sys\UserController@personal_password');
	Route::post('/user/personal-edit','Sys\UserController@personal_edit');
	Route::post('/user/personal-head_portrait','Sys\UserController@personal_head_portrait');

	Route::post('/message/liuyan-add','Message\MessageController@liuyan_add');
	Route::any('/message/liuyan','Message\MessageController@liuyan');

Route::group(['middleware'=>['rule']],function(){

	/**
	*	user 用户
	* 	department 部门
	*/
	Route::get('/user/department','Sys\UserController@department');
	Route::any('/user/departments','Sys\UserController@departments');
	Route::post('/user/department-add','Sys\UserController@department_add');
	Route::post('/user/department-edit','Sys\UserController@department_edit');
	Route::post('/user/department-del','Sys\UserController@department_del');

	/**
	*	nav 导航
	* 	menu 左侧菜单导航
	*/
	Route::get('/nav/menu/','Sys\MenuController@menu');
	Route::post('/nav/menu-add/','Sys\MenuController@menu_add');
	Route::post('/nav/menu-edit/','Sys\MenuController@menu_edit');
	Route::post('/nav/menu-del/','Sys\MenuController@menu_del');
	Route::post('/nav/menu-sort/','Sys\MenuController@menu_sort');

	/**
	*	power 权限控制
	* 	rule 权限列表
	*/
	Route::any('/power/rule','Sys\PowerController@rule');
	Route::post('/power/rule-edit','Sys\PowerController@rule_edit');
	Route::post('/power/rule-del','Sys\PowerController@rule_del');
	Route::post('/power/rule-add','Sys\PowerController@rule_add');
	/**
	*	power 权限控制
	* 	cate 权限分类
	*/
	Route::any('/power/cate','Sys\PowerController@cate');
	Route::post('/power/cate-edit','Sys\PowerController@cate_edit');
	Route::post('/power/cate-del','Sys\PowerController@cate_del');
	Route::post('/power/cate-add','Sys\PowerController@cate_add');
	/**
	*	power 权限控制
	* 	role 权限角色
	*/
	Route::any('/power/role','Sys\PowerController@role');
	Route::post('/power/role-add','Sys\PowerController@role_add');
	Route::post('/power/role-del','Sys\PowerController@role_del');
	Route::post('/power/role-edit','Sys\PowerController@role_edit');

	/**
	*	user 用户
	* 	user 用户管理
	*/
	Route::any('/user/user','Sys\UserController@user');
	Route::post('/user/user-status','Sys\UserController@user_status');
	Route::post('/user/user-add','Sys\UserController@user_add');
	Route::post('/user/user-edit','Sys\UserController@user_edit');
	Route::post('/user/user-del','Sys\UserController@user_del');

	/**
	*	developer 开发商模块
	*	project 项目
	* 	company 开发商管理
	* 	contacts 联系人
	* 	information 信息
	* 	appointment 项目洽谈
	* 	feedback 项目洽谈反馈
	*/
	Route::any('/developer/company','Developer\CompanyController@company');
	Route::post('/developer/company-add','Developer\CompanyController@company_add');
	Route::post('/developer/company-edit','Developer\CompanyController@company_edit');
	Route::post('/developer/company-del','Developer\CompanyController@company_del');

	Route::any('/developer/contacts','Developer\CompanyController@contacts');
	Route::post('/developer/contacts-add','Developer\CompanyController@contacts_add');
	Route::post('/developer/contacts-edit','Developer\CompanyController@contacts_edit');
	Route::post('/developer/contacts-del','Developer\CompanyController@contacts_del');

	Route::any('/developer/information','Developer\CompanyController@information');
	Route::any('/developer/information-add','Developer\CompanyController@information_add');
	Route::any('/developer/information-edit','Developer\CompanyController@information_edit');
	Route::any('/developer/information-del','Developer\CompanyController@information_del');

	Route::any('/developer/project','Developer\ProjectController@project');
	Route::post('/developer/project-add','Developer\ProjectController@project_add');
	Route::post('/developer/project-edit','Developer\ProjectController@project_edit');
	Route::post('/developer/project-del','Developer\ProjectController@project_del');

	Route::any('/developer/project/contacts','Developer\ProjectController@contacts');
	Route::post('/developer/project/contacts-add','Developer\ProjectController@contacts_add');
	Route::post('/developer/project/contacts-edit','Developer\ProjectController@contacts_edit');
	Route::post('/developer/project/contacts-del','Developer\ProjectController@contacts_del');

	Route::any('/developer/project/information','Developer\ProjectController@information');
	Route::post('/developer/project/information-add','Developer\ProjectController@information_add');
	Route::post('/developer/project/information-edit','Developer\ProjectController@information_edit');
	Route::post('/developer/project/information-del','Developer\ProjectController@information_del');

	Route::any('/developer/project/appointment','Developer\ProjectController@appointment');
	Route::post('/developer/project/appointment-add','Developer\ProjectController@appointment_add');
	Route::post('/developer/project/appointment-edit','Developer\ProjectController@appointment_edit');
	Route::post('/developer/project/appointment-del','Developer\ProjectController@appointment_del');

	Route::post('/developer/project/feedback-add','Developer\ProjectController@feedback_add');


	/**
	*	engineering 工程模块
	*	project 项目
	* 	house 房间
	* 	schedule 进度
	* 	album 相册
	*/
	Route:: any('/engineering/project','Engineering\ProjectController@project');
	Route:: post('/engineering/project-add','Engineering\ProjectController@project_add');
	Route:: post('/engineering/project-edit','Engineering\ProjectController@project_add');
	Route:: post('/engineering/project-del','Engineering\ProjectController@project_del');

	Route::any('/engineering/project/house','Engineering\ProjectController@house');

	Route::get('/engineering/project/house/schedule','Engineering\ProjectController@schedule');
	Route::post('/engineering/project/house/schedule-add','Engineering\ProjectController@schedule_add');

	Route::any('/engineering/project/house/album','Engineering\ProjectController@album');
	Route::post('/engineering/project/house/album-add','Engineering\ProjectController@album_add');
	Route::post('/engineering/project/house/album-edit','Engineering\ProjectController@album_edit');
	Route::post('/engineering/project/house/album-del','Engineering\ProjectController@album_del');
	Route::get('/engineering/project/house/album-check','Engineering\ProjectController@album_check');
	
	/**
	*	customer 客户模块
	*	owner 客户
	* 	house 房间
	* 	schedule 交涉进度
	*/
	Route::any('/customer/owner','Customer\OwnerController@owner');
	Route::post('/customer/owner-add','Customer\OwnerController@owner_add');
	Route::post('/customer/owner-edit','Customer\OwnerController@owner_edit');
	Route::post('/customer/owner-del','Customer\OwnerController@owner_del');

	Route::any('/customer/owner/house','Customer\OwnerController@house');
	Route::post('/customer/owner/house-add','Customer\OwnerController@house_add');
	Route::post('/customer/owner/house-edit','Customer\OwnerController@house_edit');
	Route::post('/customer/owner/house-del','Customer\OwnerController@house_del');
	Route::get('/customer/owner/house/engineering-schedule','Customer\OwnerController@engineering_schedule');
	Route::get('/customer/owner/house/album','Customer\OwnerController@album');
	Route::post('customer/owner/house/demand-edit','Customer\OwnerController@demand_edit');

	Route::any('/customer/owner/house/schedule','Customer\OwnerController@schedule');
	Route::post('/customer/owner/house/schedule-add','Customer\OwnerController@schedule_add');
	Route::post('/customer/owner/house/schedule-edit','Customer\OwnerController@schedule_edit');
	Route::post('/customer/owner/house/schedule-del','Customer\OwnerController@schedule_del');

	/**
	*	supplier 材料模块
	*	category 开发商
	* 	house 房间
	* 	material 材料
	*/
	Route::any('/supplier/supply','Supplier\SupplierController@supply');
	Route::post('/supplier/supply-add','Supplier\SupplierController@supply_add');
	Route::post('/supplier/supply-edit','Supplier\SupplierController@supply_edit');
	Route::post('/supplier/supply-del','Supplier\SupplierController@supply_del');

	Route::any('/supplier/category','Supplier\SupplierController@category');
	Route::post('/supplier/category-add','Supplier\SupplierController@category_add');
	Route::post('/supplier/category-edit','Supplier\SupplierController@category_edit');
	Route::post('/supplier/category-del','Supplier\SupplierController@category_del');

	Route::any('/supplier/material','Supplier\SupplierController@material');
	Route::post('/supplier/material-add','Supplier\SupplierController@material_add');
	Route::post('/supplier/material-edit','Supplier\SupplierController@material_edit');
	Route::post('/supplier/material-del','Supplier\SupplierController@material_del');


	Route::any('/supplier/query','Supplier\QueryController@query');
	Route::any('/supplier/query-project','Supplier\QueryController@query_project');
	/**
	*	design 设计模块
	*	huxing 户型
	* 	house 房间
	* 	drawing 设计图
	* 	material 材料清单
	*/
	Route::any('/design/huxing','Design\DesignController@huxing');
	Route::post('/design/huxing-add','Design\DesignController@huxing_add');
	Route::post('/design/huxing-edit','Design\DesignController@huxing_edit');
	Route::post('/design/huxing-del','Design\DesignController@huxing_del');
	Route::post('/design/huxing-upload','Design\DesignController@huxing_upload');
	Route::get('/huxing/download','Design\DesignController@huxing_download');

	Route::any('/design/house','Design\DesignController@house');
	Route::post('/design/house-add','Design\DesignController@house_add');
	Route::any('/design/house-edit','Design\DesignController@house_edit');
	Route::post('/design/house-del','Design\DesignController@house_del');

	Route::any('/design/house/drawing','Design\DrawingController@drawing');
	Route::post('/design/house/drawing-add','Design\DrawingController@drawing_add');
	Route::post('/design/house/drawing-edit','Design\DrawingController@drawing_edit');
	Route::post('/design/house/drawing-del','Design\DrawingController@drawing_del');
	Route::post('/design/house/drawing-upload','Design\DrawingController@drawing_upload');
	Route::get('/design/house/drawing-download','Design\DrawingController@drawing_download');

	Route::any('/design/house/material','Design\MaterialController@material');
	Route::post('/design/house/material-edit','Design\MaterialController@material_edit');
	Route::post('/design/house/material-del','Design\MaterialController@material_del');

	Route::any('/design/house/material-selection','Design\MaterialController@material_selection');
	Route::post('/design/house/material-selection-add','Design\MaterialController@material_selection_add');
});
});
Route::get('/login',function() {	
    \session()->forget('user');
	return view('Sys.Login.login');
});
Route::post('/dologin','Sys\LoginController@dologin');
