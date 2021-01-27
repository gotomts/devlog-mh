<?php

use App\Models\Post;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * DBチューニング用に大量のダミー記事を追加する
 */
class DBTuningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 記事を一旦削除
        \DB::table('posts')->truncate();
        \DB::table('posts_member_types')->truncate();

        // 記事に入れるテキスト取得
        $markdownContent = \Storage::disk('content')->get('markdown/dummy.md');
        $htmlContent = \Storage::disk('content')->get('html/dummy.html');

        // 日付算出用
        $time = new Carbon();

        // 記事作成
        for ($i=0; $i < 20; $i++) {
            $postsList = [];
            for ($j=0; $j < 500; $j++) {
                $id = uniqid();
                $day = $time->subSecond("${i}" . "${j}");
                $posts = [
                    'url' => "db-tuning${id}",
                    'title' => "DBチューニング用のパフォーマンス確認記事${id}",
                    'keyword' => "keyword1, keyword2, keyword3",
                    'description' => "description",
                    'markdown_content' => $markdownContent,
                    'html_content' => $htmlContent,
                    'status_id' => config('const.statuses.publishing'),
                    'category_id' => 1,
                    'created_by' => 1,
                    'created_at' => $day,
                    'updated_by' => 1,
                    'updated_at' => $day,
                ];
                array_push($postsList, $posts);
            }
            \DB::table('posts')->insert($postsList);
        }



        // // 会員限定ページ
        // for ($sumIndex=0; $sumIndex < 5000; $sumIndex++) {
        //     $posts = new Post();
        //     $posts->url = "db-tuning${sumIndex}";
        //     $posts->title = "DBチューニング用のパフォーマンス確認記事${i}";
        //     $posts->keyword = "keyword1, keyword2, keyword3";
        //     $posts->description = "description";
        //     $posts->markdown_content = $markdownContent;
        //     $posts->html_content = $htmlContent;
        //     $posts->status_id = config('const.statuses.member_limitation');
        //     $posts->category_id = 1;
        //     $posts->created_by = 1;
        //     $posts->updated_by = 1;
        //     $posts->save();

        //     $posts->memberTypes()->attach([config('const.member_types.general')]);
        // }
    }
}
