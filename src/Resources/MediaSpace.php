<?php
/*
 * This file is part of shopee-php.
 *
 * Copyright (c) 2024 Jin <j@sax.vn> All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EcomPHP\Shopee\Resources;

use EcomPHP\Shopee\Resource;
use GuzzleHttp\RequestOptions;

class MediaSpace extends Resource
{
    /**
     * API: v2.media_space.init_video_upload
     * Initiate video upload session. Video duration should be between 10s and 60s (inclusive).
     */
    public function initVideoUpload($file_md5, $file_size)
    {
        return $this->call('POST', 'media_space/init_video_upload', [
            RequestOptions::JSON => [
                'file_md5' => $file_md5,
                'file_size' => $file_size,
            ]
        ]);
    }

    /**
     * API: v2.media_space.upload_video_part
     * Upload video file by part using the upload_id in initiate_video_upload. The request Content-Type of this API should be of multipart/form-data
     */
    public function uploadVideoPart($video_upload_id, $part_seq, $content_md5, $part_content)
    {
        return $this->call('POST', 'media_space/upload_video_part', [
            RequestOptions::JSON => [
                'video_upload_id' => $video_upload_id,
                'part_seq' => $part_seq,
                'content_md5' => $content_md5,
                'part_content' => $part_content,
            ]
        ]);
    }

    /**
     * API: v2.media_space.complete_video_upload
     * Complete the video upload and starts the transcoding process when all parts are uploaded successfully.
     */
    public function completeVideoUpload($video_upload_id, $part_seq_list)
    {
        return $this->call('POST', 'media_space/complete_video_upload', [
            RequestOptions::JSON => [
                'video_upload_id' => $video_upload_id,
                'part_seq_list' => $part_seq_list,
            ]
        ]);
    }

    /**
     * API: v2.media_space.get_video_upload_result
     * Query the upload status and result of video upload.
     */
    public function getVideoUploadResult($video_upload_id)
    {
        return $this->call('GET', 'media_space/get_video_upload_result', [
            RequestOptions::QUERY => [
                'video_upload_id' => $video_upload_id,
            ]
        ]);
    }

    /**
     * API: v2.media_space.cancel_video_upload
     * Cancel a video upload session
     */
    public function cancelVideoUpload($video_upload_id)
    {
        return $this->call('POST', 'media_space/cancel_video_upload', [
            RequestOptions::JSON => [
                'video_upload_id' => $video_upload_id,
            ]
        ]);
    }

    /**
     * API: v2.media_space.upload_image
     * Use this API to upload multiple image files (less than 9 images).
     */
    public function uploadImage($image, $scene = null, $ratio = null)
    {
        $filename = 'image.jpg';
        if ($image instanceof \SplFileInfo) {
            $filename = $image->getFilename();
            $image = file_get_contents($image->getPathname());
        }

        return $this->call('POST', 'media_space/upload_image', [
            RequestOptions::MULTIPART => [
                [
                    'name' => 'image',
                    'contents' => $image,
                    'filename' => $filename,
                ],
                [
                    'name' => 'scene',
                    'contents' => $scene,
                ],
                [
                    'name' => 'ratio',
                    'contents' => $ratio,
                ]
            ]
        ]);
    }
}
