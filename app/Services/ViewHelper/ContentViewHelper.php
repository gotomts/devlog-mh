<?php

namespace App\Services\ViewHelper;

class ContentViewHelper
{
    /**
     * 「const.more_keyword」で分岐してコンテンツを返却
     *
     * @return string $content
     */
    public function getExistsMoreContent($htmlContent)
    {
        // 「const.more_keyword」の存在確認（存在する場合は存在位置を取得）
        $existsMore = strpos($htmlContent, config('const.more_keyword'));
        if ($existsMore) {
            // 存在する場合、「const.more_keyword」までのHTMLを返却
            $content = substr($htmlContent, 0, $existsMore);
        } else {
            // 存在しない場合、HTMLすべてを返却
            $content = $htmlContent;
        }

        return $content;
    }
}
