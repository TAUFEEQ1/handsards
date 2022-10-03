<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Debug\Toolbar\Collectors\Logs;
use SplFileObject;

class DirectoryAccessSeeder extends Seeder
{
    public function run()
    {
        //
        $path = APPPATH."/Database/Seeds/";
        $data = [
            ['title'=>'Parliament Hansard 30-Aug','content'=>'','publish_date'=>'2022-08-25','path'=>'August30_2022']
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
