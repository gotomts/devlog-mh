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
        for ($i=0; $i < 100; $i++) {
            $postsList = [];
            for ($j=0; $j < 100; $j++) {
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
                    'category_id' => mt_rand(1, 3),
                    'created_by' => 1,
                    'created_at' => $day,
                    'updated_by' => 1,
                    'updated_at' => $day,
                ];
                array_push($postsList, $posts);
            }
            \DB::table('posts')->insert($postsList);
        }

        // 記事作成
        for ($i=0; $i < 100; $i++) {
            $postsList = [];
            for ($j=0; $j < 100; $j++) {
                $id = uniqid();
                $day = $time->subSecond("${i}" . "${j}");
                $posts = [
                    'url' => "db-tuning${id}",
                    'title' => "DBチューニング用のパフォーマンス確認記事${id}",
                    'keyword' => "keyword1, keyword2, keyword3",
                    'description' => "description",
                    'markdown_content' => $markdownContent,
                    'html_content' => $htmlContent,
                    'status_id' => config('const.statuses.member_limitation'),
                    'category_id' => mt_rand(1, 3),
                    'created_by' => 1,
                    'created_at' => $day,
                    'updated_by' => 1,
                    'updated_at' => $day,
                ];
                array_push($postsList, $posts);
            }
            \DB::table('posts')->insert($postsList);
        }

        // 記事と会員種別の紐付け
        $postsAll = Post::where('id', '>', '10000')->get();
        $memberTypesList = [];
        foreach ($postsAll as $post) {
            $memberTypes = [
                'posts_id' => $post->id,
                'member_types_id' => config('const.member_types.general'),
            ];
            array_push($memberTypesList, $memberTypes);
        }
        \DB::table('posts_member_types')->insert($memberTypesList);
    }
}
