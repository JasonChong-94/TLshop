<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/15
 * Time: 10:49
 */
namespace app\services;

use think\facade\Log;

class FileService
{
    /**
     * 实现文件上传
     * @param object $file 上传的文件的对象信息
     * @param string $path 文件上传的目录
     * @return mixed
     */
    public function image($file, $path)
    {
        try {
            // 判断逻辑错误
            $maxSize = 800 * 1024;//kb
            if ($file->getSize() > $maxSize) {
                Log::write('上传失败，超出了文件限制的大小','notice');
                return false;
            }

            // 判断文件类型
            $ext = strtolower($file->getOriginalExtension());
            if (!in_array($ext, ['png', 'jpg', 'jpeg', 'pdf', 'webp'], true)) {
                // 非法的文件类型
                Log::write('上传的图片的类型不正确','notice');
                return false;
            }
            $savename = \think\facade\Filesystem::disk('public')->putFile( $path,$file);
            return 'storage/'.$savename;
        } catch (\Exception $e) {
            Log::write($e->getMessage() . $e->getLine(),'notice');
            return false;
        }
    }
    /**
     * 批量上传图片
     * @param object $file
     * @param string $path 文件上传的目录
     * @return array
     */
    public function images($file,$path)
    {
        // 设定文件上传的大小
        $fileSize = 1024 * 1024 * 2;
        // 存储上传失败的信息
        $error = [];
        // 存储上传成功的信息
        $success = [];
        // 循环批量验证
        foreach ($file as $val) {
            // 捕获异常
            try {
                // 验证文件大小、后缀
                validate(['images' => 'fileSize:' . $fileSize . '|fileExt:jpg,png'])
                    ->check(['images' => $val]);
                // 上传文件
                $saveName = \think\facade\Filesystem::disk('public')->putFile($path, $val);
                // 将成功后的路径保存到数组中
                $success[] = 'storage/' . $saveName;
            } catch (\think\exception\ValidateException $e) {
                // 记录验证错误的失败信息
                $error= [
                    'name' => $val->getOriginalName(),
                    'msg' => $e->getMessage()
                ];
            }
        }
        // 组装返回数据的结果集
        $data = [
            'success' => $success,
            'error' => $error
        ];
        // 返回数据
        return $data;
    }
    /**
     * 删除文件
     * @param string $path 文件的目录
     * @return bool
     */
    public function delete($path)
    {
        unlink(public_path().$path);
        return true;
    }
}