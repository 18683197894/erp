<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Developer\Project;
use App\Model\Engineering\House;
use App\Model\Cost\CostEstimateDetailed;
class EstimateController extends Controller
{
    //
      public function estimate(Request $request)
      {
         if($request->isMethod('get'))
         {  
            $project = Project::where('status',2)->get();
            return view('Cost.Estimate.estimate',[
               'project' => $project,
           ]);
         }else
         {
            $formData['project_id'] = $request->post('project_id','');
            $formData['unit'] = $request->post('unit','');
            $formData['building'] = $request->post('building','');
            $formData['floor'] = $request->post('floor','');
            $formData['room_number'] = $request->post('room_number','');
            $data = House::select('*')
                  ->where('project_id','like','%'.$formData['project_id'].'%')
                  ->where('unit','like','%'.$formData['unit'].'%')
                  ->where('building','like','%'.$formData['building'].'%')
                  ->where('floor','like','%'.$formData['floor'].'%')
                  ->where('room_number','like','%'.$formData['room_number'].'%')
                  ->where('status','>',0)
                  ->with(['Huxing'=>function($query){
                           return $query->select('*')->get();
                        },'Template'=>function($query){
                           return $query->select('id','project_id','room_number','floor','building','unit')
                              ->with(['Project'=>function($query){
                                 return $query->select('id','name')->get();
                        }])->get();
                        },'Project'=>function($query){
                           return $query->select('id','name')->get();
                        },'CostEstimateDetaileds'=>function($query){
                           return $query->select('*')->get();
                        },'Materials'=>function($query){
                           return $query->select('*')->get();
                        },'EngineeringMaterials'=>function($query){
                           return $query->select('*')->get();
                        }])
                  ->orderBy('created_at','DESC')
                  ->offset(($request->page -1) * $request->limit)
                  ->limit($request->limit)
                  ->get()
                  ->toArray();
               foreach($data as $k=>$v)
               {  
                  $data[$k]['budget_price'] = 0;
                  $data[$k]['settlement_price'] = 0;
                  if($v['huxing'])
                  {
                      $data[$k]['huxing_name'] = $v['huxing']['name'];
                  }
                  if($v['project'])
                  {
                      $data[$k]['project_name'] = $v['project']['name'];
                  }
                  if($v['template'])
                  {
                     $data[$k]['template_name'] = $v['template']['project']['name'].$v['building'].'栋'.$v['unit'].'单元'.$v['floor'].'层'.$v['room_number'].'号';
                  }
                  if($v['is_template'] == 1)
                  {
                     $data[$k]['template_name'] = '样板房';
                  }
                  foreach($v['cost_estimate_detaileds'] as $kk => $vv)
                  {
                     $data[$k]['budget_price'] = bcadd($data[$k]['budget_price'],$vv['total'],2);
                  }
                  foreach($v['materials'] as $kkk => $vvv)
                  {  
                     $data[$k]['settlement_price'] = bcadd(bcadd($data[$k]['settlement_price'],$vvv['artificial_price'],2),bcmul($vvv['purchase_price'],$vvv['num'],2),2);
                  }
                  foreach($v['engineering_materials'] as $kkkk => $vvvv)
                  {  
                     $data[$k]['settlement_price'] = bcadd(bcadd(bcadd($data[$k]['settlement_price'],$vvvv['artificial_price'],2),bcmul($vvvv['purchase_price'],$vvvv['num'],2),2),$vvvv['other_price'],2);
                  }
                  $data[$k]['difference_price'] = bcsub($data[$k]['budget_price'],$data[$k]['settlement_price'],2);
                  $data[$k]['settlement_price'] = $data[$k]['settlement_price']?$data[$k]['settlement_price']:'';
                  $data[$k]['budget_price'] = $data[$k]['budget_price']?$data[$k]['budget_price']:'';
                  $data[$k]['difference_price'] = $data[$k]['difference_price']?$data[$k]['difference_price']:'';
               }
            $total = House::select('*')
                  ->where('project_id','like','%'.$formData['project_id'].'%')
                  ->where('unit','like','%'.$formData['unit'].'%')
                  ->where('building','like','%'.$formData['building'].'%')
                  ->where('floor','like','%'.$formData['floor'].'%')
                  ->where('room_number','like','%'.$formData['room_number'].'%')
                  ->where('status','>',0)
                  ->count();
            $this->tableData($total,$data,'获取成功',0);
         }
      }
      public function estimate_edit(Request $request)
      {
         $house = House::find($request->id);
         if($house)
         {
            $house->concept_price = $request->concept_price;
            $house->save();
            $this->success_message('修改成功');
         }
         $this->error_message('修改失败 数据不存在');
      }
      public function detailed(Request $request)
      {
         if($request->isMethod('get'))
         {
            $house = House::find($request->get('house_id'));
            if(!$house) die('数据不存在');
            return view('Cost.Estimate.detailed',[
               'house'=>$house
            ]);
         }else
         {
            $data = CostEstimateDetailed::select('*')
                  ->where('house_id',$request->house_id)
                  ->orderBy('created_at','DESC')
                  ->offset(($request->page -1) * $request->limit)
                  ->limit($request->limit)
                  ->get();
            $total = CostEstimateDetailed::select('*')
                  ->where('house_id',$request->house_id)
                  ->count();
            $this->tableData($total,$data,'获取成功',0);
         }
      }

      public function detailed_add(Request $request)
      {
         $data = $request->except('_token');
         if(CostEstimateDetailed::create($data))
         {
            $this->success_message('新增成功');
         }else
         {
            $this->error_message('新增失败');
         }
      }
      public function detailed_edit(Request $request)
      {
         $data = $request->except('_token');
         CostEstimateDetailed::where('id',$request->id)->update($data);
         $this->success_message('编辑成功');
      }

      public function detailed_del(Request $request)
      {
         CostEstimateDetailed::destroy($request->id);
         $this->success_message('删除成功');
      }
}
