<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Debug\Toolbar\Collectors\Logs;
use SplFileInfo;
use SplFileObject;

class DirectoryAccessSeeder extends Seeder
{
    public function run()
    {
        //
        $path = APPPATH."/Database/Seeds/";
        $data = [
            ['title'=>'Parliament Hansard 08-Sept-2022', 'content'=>'', 'publish_date'=>'2022-09-08','path'=>'September08_2022'],
            ['title'=>'Parliament Hansard 07-Sept-2022','content'=>'','publish_date'=>'2022-09-07','path'=>'September07_2022'],
            ['title'=>'Parliament Hansard 11-Aug-2022','content'=>'','publish_date'=>'2022-08-11','path'=>'August11_2022']

        ];
        $result = [];
        foreach($data as $fyl){
            // load files
            $fpath = $path.$fyl['path'].'.txt';
            // @var SplFileInfoObject
            $file = new SplFileObject($fpath,'r');
            $contents = $file->fread($file->getSize());
            $tmp = [
                'title'=>$fyl['title'],
                'content'=>$contents,
                'publish_date'=>$fyl['publish_date']
            ];
            array_push($result,$tmp);
        }
        $this->db->table('directory_access')->insertBatch($result);
    }
}
