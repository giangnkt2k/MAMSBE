<?php


namespace Enum;


use Enum;

/**
 * @OA\Schema(
 *     title="BlogSubType",
 *     description="loại bài viết phụ:
 *     - `1`: Loai 1
 *     - `2`: Loai 2",
 *     type="int",
 *     enum={1,2},
 * )
 */

class BlogSubTypeEnumEnum extends Enum
{
    const SUBTYPE1  = [1, 'loại 1'];
    const SUBTYPE2 = [2, 'loại 2'];
}

