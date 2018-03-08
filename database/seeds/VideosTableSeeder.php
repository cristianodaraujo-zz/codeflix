<?php

use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $playlists = \App\Models\Playlist::all();
        $categories = \App\Models\Category::all();
        $repository = app(\App\Repositories\VideoRepository::class);
        $thumbnails = $this->thumbnails();
        $archives = $this->archives();

        factory(\App\Models\Video::class, 5)->create()
            ->each(function ($video) use ($playlists, $categories, $repository, $thumbnails, $archives) {
                $video->categories()->attach($categories->random(4)->pluck('id'));
                $repository->uploadThumbnail($video->id, $thumbnails->random());
                $repository->uploadArchive($video->id, $archives->random());

                if (rand(1, 3) == 2) {
                    $video->playlist()->associate($playlists->random())->save();
                }
        });
    }

    protected function thumbnails()
    {
        return new \Illuminate\Support\Collection([
            new \Illuminate\Http\UploadedFile(storage_path('app/files/faker/images/php.jpg'), 'php.jpg')
        ]);
    }

    protected function archives()
    {
        return new \Illuminate\Support\Collection([
            new \Illuminate\Http\UploadedFile(storage_path('app/files/faker/videos/countdown.mp4'), 'countdown.mp4')
        ]);
    }
}
