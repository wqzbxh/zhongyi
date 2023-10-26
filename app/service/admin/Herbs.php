<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/9/3
 * Time:  2:11
 */

namespace app\service\admin;

use app\Resource\HerbsReturn;
use app\service\Common;
use support\Db;
use support\Model;

class Herbs
{
    protected $Model = 'HerbsReturn';

    public function getList($page,$limit,$search,$query)
    {
        $Common = new Common($this->Model);
        $result =  $Common->getList($page,$limit,$search,$query);
        if(count($result['data']) > 0){
            $BooksService = new Books();
            $BooksDataObj= new \app\model\Books();
            $book_id = collect($result['data'])->pluck($BooksDataObj->main_key)->toArray();
            // 使用array_unique()函数去除重复元素
            $book_id = array_unique($book_id);
            $conditons['key'] = $BooksDataObj->main_key;
            $conditons['operator'] = 'whereIn';
            $conditons['value'] = $book_id;
            $BooksService->geDataObj();
            $result_books = $BooksService->getCollectionBasedOnConditions([$conditons]);

            $MedicinalSmellService = new MedicinalSmell();
            $MedicinalSmellDataObj= new \app\model\MedicinalSmell();
            $medicinal_smell_id = collect($result['data'])->pluck($MedicinalSmellDataObj->main_key)->toArray();

            $medicinalArr = implode(',',$medicinal_smell_id);
            $medicinal_smell_id = explode(',',$medicinalArr);
            // 使用array_unique()函数去除重复元素
            $medicinal_smell_id = array_unique($medicinal_smell_id);

            $conditons['key'] = $MedicinalSmellDataObj->main_key;
            $conditons['operator'] = 'whereIn';
            $conditons['value'] = $medicinal_smell_id;
            $result_medicinal_smell = $MedicinalSmellService->getCollectionBasedOnConditions([$conditons]);



            $MedicineCharacteService = new MedicineCharacter();
            $MedicineCharacteDataObj= new \app\model\MedicineCharacter();
            $character_id = collect($result['data'])->pluck($MedicineCharacteDataObj->main_key)->toArray();
            $characterlArr = implode(',',$character_id);
            $character_id = explode(',',$characterlArr);
            // 使用array_unique()函数去除重复元素
            $character_id = array_unique($character_id);

            $conditons['key'] = $MedicineCharacteDataObj->main_key;
            $conditons['operator'] = 'whereIn';
            $conditons['value'] = $medicinal_smell_id;
            $result_medicine_character = $MedicineCharacteService->getCollectionBasedOnConditions([$conditons]);


            foreach($result['data'] as $key => $item){
                foreach ($result_books as $bookItem){
                    if($bookItem->book_id == $item->book_id ){
                        $result['data'][$key]->book_name = $bookItem->book_name;
                    }
                }


                $medicinal_smell_arr = [];
                foreach ($result_medicinal_smell as $medicinal_smell_item){
                    $row_medicinal_smell = explode(',',$item->medicinal_smell_id);
                    foreach ($row_medicinal_smell as $row_medicinal_smell_item){
                        if($medicinal_smell_item->medicinal_smell_id == $row_medicinal_smell_item){
                            array_push($medicinal_smell_arr,$medicinal_smell_item->medicinal_smell_name);
                        }
                    }
                }
                $medicinalStr = implode(',',$medicinal_smell_arr);
                $result['data'][$key]->medicinal_smell_name = $medicinalStr;

                $medicine_character_arr  = [];
                foreach ($result_medicine_character as $medicine_character_item){
                    $row_medicine_character = explode(',',$item->character_id);
                    foreach ($row_medicine_character as $row_medicine_character_item){
                        if($medicine_character_item->character_id == $row_medicine_character_item){
                            array_push($medicine_character_arr,$medicine_character_item->character_name);
                        }
                    }
                }
                $characterStr = implode(',',$medicine_character_arr);
                $result['data'][$key]->medicine_character_name = $characterStr;



                $ToxicityService = new Toxicity();
                $ToxicityDataObj= new \app\model\Toxicity();
                $toxicity_id= collect($result['data'])->pluck($ToxicityDataObj->main_key)->toArray();
                $toxicity_id = array_unique($toxicity_id);
                $conditons['key'] = $ToxicityDataObj->main_key;
                $conditons['operator'] = 'whereIn';
                $conditons['value'] = $toxicity_id;
                $toxicity = $ToxicityService->getCollectionBasedOnConditions([$conditons]);

                foreach ($toxicity as $toxicityItem){
                    if($toxicityItem->toxicity_id == $item->toxicity_id ){
                        $result['data'][$key]->toxicity_name = $toxicityItem->toxicity_name;
                    }
                }

            }
        }

        return $result;
    }

    public function getHerbsDetail($id)
    {
        $returnArray= [];
        $herbsModel = new \app\model\Herbs();
        $booksModel = new \app\model\Books();
        $BooksService = new Books();

//        获取主要信息条目
        $returnArray =(array) Db::table($herbsModel->main_table)
                ->leftJoin($booksModel->main_table, "$booksModel->main_table.$booksModel->main_key", '=', "$herbsModel->main_table.book_id")
                ->where($herbsModel->main_key, $id)->first();

        $associate = $this->getInformationAboutHerbs($returnArray);
        $returnArray = array_merge($returnArray,$associate);

//        获取主要信息条目
        $otherHerbs =(array) Db::table($herbsModel->main_table)
            ->where('common_name', $returnArray['common_name'])
            ->where($herbsModel->main_key, '<>', $id)
            ->get()->toArray();
        $returnArray['other'] = [];

        $book_id = collect($otherHerbs)->pluck($booksModel->main_key)->toArray();
        // 使用array_unique()函数去除重复元素
        $book_id = array_unique($book_id);
        $conditons['key'] = $booksModel->main_key;
        $conditons['operator'] = 'whereIn';
        $conditons['value'] = $book_id;
        $BooksService->geDataObj();
        $result_books = $BooksService->getCollectionBasedOnConditions([$conditons]);


        foreach ($otherHerbs as $key=> $item){
            $associate = $this->getInformationAboutHerbs((array)$item);
            $otherHerbs[$key] = array_merge((array)$otherHerbs[$key],$associate);
            foreach ($result_books as $key => $value){
                if($value->book_id == $item->book_id){
                    $otherHerbs[$key]['book_name'] = $value->book_name;
                }
            }

        }

        $returnArray['other'] =$otherHerbs;

        return $returnArray;

    }


    // 获取味道毒性特性信息
    public function getInformationAboutHerbs($data)
    {
        $returnArray = [];
        $MedicinalSmellService = new MedicinalSmell();
        $MedicinalSmellDataObj= new \app\model\MedicinalSmell();

//        获取味道毒性特性信息
        if(!empty($data['medicinal_smell_id'])){
            $medicinal_smell_ids = explode(',',$data['medicinal_smell_id']);
            $conditons['key'] = $MedicinalSmellDataObj->main_key;
            $conditons['operator'] = 'whereIn';
            $conditons['value'] = $medicinal_smell_ids;
            $result_medicinal_smell = $MedicinalSmellService->getCollectionBasedOnConditions([$conditons]);
            $medicinal_smell_name = collect($result_medicinal_smell)->pluck('medicinal_smell_name')->toArray();
            $returnArray['medicinal_smell_name'] = implode(',',$medicinal_smell_name);
        }


//        获取味道毒性特性信息
        if(!empty($data['medicinal_smell_id'])){
            $ToxicityService = new Toxicity();
            $ToxicityDataObj= new \app\model\Toxicity();
            $toxicity_id = explode(',',$data['toxicity_id']);
            $conditons['key'] = $ToxicityDataObj->main_key;
            $conditons['operator'] = 'whereIn';
            $conditons['value'] = $toxicity_id;
            $toxicity = $ToxicityService->getCollectionBasedOnConditions([$conditons]);
            $toxicity = collect($toxicity)->pluck('toxicity_name')->toArray();
            $returnArray['toxicity_name'] = implode(',',$toxicity);
        }


        //        获取味道毒性特性信息
        if(!empty($data['character_id'])){
            $MedicineCharacteService = new MedicineCharacter();
            $MedicineCharacteDataObj= new \app\model\MedicineCharacter();
            $character_id = explode(',',$data[$MedicineCharacteDataObj->main_key]);
            $conditons['key'] = $MedicineCharacteDataObj->main_key;
            $conditons['operator'] = 'whereIn';
            $conditons['value'] = $character_id;
            $result_medicine_character = $MedicineCharacteService->getCollectionBasedOnConditions([$conditons]);
            $character_name = collect($result_medicine_character)->pluck('character_name')->toArray();
            $returnArray['character_name'] = implode(',',$character_name);
        }

        return $returnArray;
    }


    public function getSelectListAll()
    {
        $model = new \app\model\Herbs();
        $table = $model->main_table;
        $result = Db::table($table)
            ->select($model->selectFiled)
            ->get()->toArray();
//        $myObject = new HerbsReturn('select',$result);
//        $stringRepresentation = (array)$myObject;
//        var_dump($stringRepresentation);
        return $result;
    }
}