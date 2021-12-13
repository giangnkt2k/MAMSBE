<?php


namespace Enum;


use Enum;

/**
 * @OA\Schema(
 *     title="BlogType",
 *     description="loại bài viết:
 *     - `1`: Loai 1
 *     - `2`: Loai 2",
 *     type="int",
 *     enum={1,2},
 * )
 */

class BlogStatusEnum extends Enum
{
    const TYPE1  = [1, 'Đang hoạt động'];
    const TYPE2 = [2, 'Đã khóa'];
}

