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

	Route::any('/app/message','App\MessageController@message');
	Route::post('/app/message-edit','App\MessageController@message_edit');
	Route::any('/app/message-detail','App\MessageController@message_detail');
	Route::any('/app/message-unread','App\MessageController@unread');

	Route::any('/app/msg_letter','App\MsgController@msg_letter');
	Route::any('/app/msg_notice','App\MsgController@msg_notice');
	Route::any('/app/msg_sys','App\MsgController@msg_sys');

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
// **********市场部**********************************************************************************
	/**
	*	developer 市场部模块
	*	project 项目
	* 	company 开发商管理
	* 	contacts 联系人
	* 	information 信息
	* 	appointment 项目进度
	* 	feedback 项目洽谈反馈
	* 	screening 信息筛选
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

	Route::any('/developer/project/screening','Developer\ProjectController@screening');
	Route::post('/developer/project/screening-edit','Developer\ProjectController@screening_edit');
// ***********商务部*************************************************************************
	/**
	 * summary 商务板块 项目进度汇总
	 */
	Route::any('/commerce/summary','Developer\ProjectController@summary');


// ***********设计部**************************************************************************

	//房屋信息
	Route::any('/design/house','Design\HouseController@house');
	Route::post('/design/house-add','Design\HouseController@house_add');
	Route::any('/design/house-edit','Design\HouseController@house_edit');
	Route::post('/design/house-del','Design\HouseController@house_del');

	//户型管理
	Route::any('/desing/house/huxing','Design\HouseController@huxing');
	Route::post('/design/house/huxing-add','Design\HouseController@huxing_add');
	Route::post('/design/house/huxing-edit','Design\HouseController@huxing_edit');
	Route::post('/design/house/huxing-del','Design\HouseController@huxing_del');
	Route::post('/design/house/huxing-upload','Design\HouseController@huxing_upload');
	Route::get('/design/house/huxing/download','Design\HouseController@huxing_download');

	//业主管理
	Route::any('/design/owner','Design\OwnerController@owner');
	Route::post('/design/owner-add','Design\OwnerController@owner_add');
	Route::post('/design/owner-edit','Design\OwnerController@owner_edit');
	Route::post('/design/owner-del','Design\OwnerController@owner_del');
	//业主跟进进度
	Route::any('/design/owner/schedule','Design\OwnerController@schedule');
	Route::post('/design/owner/schedule-add','Design\OwnerController@schedule_add');
	Route::post('/design/owner/schedule-edit','Design\OwnerController@schedule_edit');
	Route::post('/design/owner/schedule-del','Design\OwnerController@schedule_del');

	//业主需求反馈
	Route::post('/design/owner/demand-edit','Design\OwnerController@demand_edit');
	
	//房屋管理
	Route::any('/design/manage','Design\ManageController@manage');
	Route::post('/design/manage-add','Design\HouseController@house_add');
	Route::any('/design/manage-edit','Design\ManageController@manage_edit');
	//房屋管理图纸管理
	Route::any('/design/manage/drawing','Design\ManageController@drawing');
	Route::post('/design/manage/drawing-add','Design\ManageController@drawing_add');
	Route::post('/design/manage/drawing-edit','Design\ManageController@drawing_edit');
	Route::post('/design/manage/drawing-del','Design\ManageController@drawing_del');
	Route::post('/design/manage/drawing-upload','Design\ManageController@drawing_upload');
	Route::get('/design/manage/drawing-download','Design\ManageController@drawing_download');

	//设计管理
	Route::any('/design/drawing','Design\DrawingController@drawing');
	Route::post('/design/drawing-add','Design\DrawingController@drawing_add');
	Route::post('/design/drawing-edit','Design\DrawingController@drawing_edit');
	Route::post('/design/drawing-del','Design\DrawingController@drawing_del');
	Route::post('/design/drawing-upload','Design\DrawingController@drawing_upload');
	Route::get('/design/drawing-download','Design\DrawingController@drawing_download');

	//材料管理
	Route::any('/design/material','Design\MaterialController@material');
	//清单列表
	Route::any('/design/material/list','Design\MaterialController@list');
	Route::post('/design/material/list-add','Design\MaterialController@list_add');
	Route::post('/design/material/list-edit','Design\MaterialController@list_edit');
	Route::post('/design/material/list-del','Design\MaterialController@list_del');

	// Route::any('/design/material/list-selection','Design\MaterialController@list_selection');
	// Route::post('/design/material/list-selection-add','Design\MaterialController@list_selection_add');
	
	//样板设计
	Route::any('/Design/template','Design\TemplateController@template');
	Route::post('/design/Template/template-band','Design\TemplateController@template_band');

	//综合查询
	Route::any('/design/query','Design\QueryController@query');


// **********材料部************************************************************************************************
	/**
	*	supplier 材料模块
	*	supply 供应商
	* 	material 材料
	* 	plan 	采购计划
	*/
	Route::any('/supplier/supply','Supplier\SupplierController@supply');
	Route::post('/supplier/supply-add','Supplier\SupplierController@supply_add');
	Route::post('/supplier/supply-edit','Supplier\SupplierController@supply_edit');
	Route::post('/supplier/supply-del','Supplier\SupplierController@supply_del');

	// Route::any('/supplier/category','Supplier\SupplierController@category');
	// Route::post('/supplier/category-add','Supplier\SupplierController@category_add');
	// Route::post('/supplier/category-edit','Supplier\SupplierController@category_edit');
	// Route::post('/supplier/category-del','Supplier\SupplierController@category_del');

	Route::any('/supplier/material','Supplier\SupplierController@material');
	Route::post('/supplier/material-add','Supplier\SupplierController@material_add');
	Route::post('/supplier/material-edit','Supplier\SupplierController@material_edit');
	Route::post('/supplier/material-del','Supplier\SupplierController@material_del');
	Route::post('/supplier/material-import','Import\ImportController@supplier_material_import');

	Route::any('/supplier/plan','Supplier\PlanController@plan');
	Route::post('/supplier/plan-add','Supplier\PlanController@plan_add');
	Route::post('/supplier/plan-edit','Supplier\PlanController@plan_edit');
	Route::post('/supplier/plan-del','Supplier\PlanController@plan_del');
	Route::post('/supplier/plan-order','Supplier\PlanController@plan_order');

	Route::any('/supplier/order','Supplier\PlanController@order');

	Route::any('/supplier/query','Supplier\QueryController@query');
	Route::any('/supplier/query-project','Supplier\QueryController@query_project');

	/**
	*	engineering 工程模块
	*/
	//项目管理
	Route:: any('/engineering/project','Engineering\ProjectController@project');
	Route:: post('/engineering/project-edit','Engineering\ProjectController@project_edit');

	//工程管理
	Route::any('/engineering/house','Engineering\ProjectController@house');
	//进度管理
	Route::get('/engineering/house/schedule','Engineering\ProjectController@schedule');
	Route::post('/engineering/house/schedule-add','Engineering\ProjectController@schedule_add');
	//相册管理
	Route::any('/engineering/house/album','Engineering\ProjectController@album');
	Route::post('/engineering/house/album-add','Engineering\ProjectController@album_add');
	Route::post('/engineering/house/album-edit','Engineering\ProjectController@album_edit');
	Route::post('/engineering/house/album-del','Engineering\ProjectController@album_del');
	Route::get('/engineering/house/album-check','Engineering\ProjectController@album_check');

	//施工管理
	Route::any('/engineering/construction','Engineering\ConstructionController@construction');
	//施工计划
	Route::any('/engineering/construction/plan','Engineering\ConstructionController@plan');
	Route::post('/engineering/construction/plan-add','Engineering\ConstructionController@plan_add');
	Route::post('/engineering/construction/plan-edit','Engineering\ConstructionController@plan_edit');
	Route::post('/engineering/construction/plan-del','Engineering\ConstructionController@plan_del');

	//综合查询
	Route::any('/engineering/query','Engineering\QueryController@query');

	//成控管理
	Route::any('/cost/estimate','Cost\EstimateController@estimate');
	Route::any('/cost/estimate-edit','Cost\EstimateController@estimate_edit');
	//成控明细
	Route::any('/cost/estimate/detailed','Cost\EstimateController@detailed');
	Route::any('/cost/estimate/detailed-add','Cost\EstimateController@detailed_add');
	Route::any('/cost/estimate/detailed-edit','Cost\EstimateController@detailed_edit');
	Route::any('/cost/estimate/detailed-del','Cost\EstimateController@detailed_del');
	Route::any('/cost/estimate/detailed-import','Import\ImportController@cost_estimate_detailed_import');
	//材料审核
	Route::any('/cost/examine/material','Cost\ExamineController@material');
	Route::any('/cost/examine/material-supplier','Cost\ExamineController@material_supplier');
	Route::any('/cost/examine/material-band','Cost\ExamineController@material_band');
	Route::any('/cost/examine/material-edit','Cost\ExamineController@material_edit');
	//施工审核
	Route::any('/cost/examine/plan','Cost\ExamineController@plan');
	Route::any('/cost/examine/plan-plan','Cost\ExamineController@plan_plan');
	Route::any('/cost/examine/plan-band','Cost\ExamineController@plan_band');
	Route::any('/cost/examine/plan-edit','Cost\ExamineController@plan_edit');
	//综合成控
	Route::any('/cost/comprehensive','Cost\StatisticsController@comprehensive');
	Route::any('/cost/comprehensive-edit','Cost\StatisticsController@comprehensive_edit');

	//财务部
	Route::any('/finance/project/department/{department_id}','Finance\ProjectController@project');
	//房间明细
	Route::any('/finance/project/price','Finance\ProjectController@price');
	Route::post('/finance/project/price-add','Finance\ProjectController@price_add');
	Route::post('/finance/project/price-edit','Finance\ProjectController@price_edit');
	Route::post('/finance/project/price-del','Finance\ProjectController@price_del');
	//提成明细
	Route::any('/finance/project/income','Finance\ProjectController@income');
	Route::any('/finance/project/income-add','Finance\ProjectController@income_add');
	Route::any('/finance/project/income-edit','Finance\ProjectController@income_edit');
	Route::any('/finance/project/income-del','Finance\ProjectController@income_del');
	//财务综合
	Route::any('/finance/query/comprehensive','Finance\QueryController@comprehensive');
	//财务预算
	Route::any('/finance/query/budget','Finance\QueryController@budget');
	Route::any('/finance/query/budget-edit','Finance\QueryController@budget_edit');

	//付款记录
	Route::any('/finance/query/payment','Finance\QueryController@payment');
	Route::any('/finance/query/income','Finance\QueryController@income');
	
	
});
});
Route::get('/login',function() {	
    \session()->forget('user');
	return view('Sys.Login.login');
});
Route::post('/dologin','Sys\LoginController@dologin');
