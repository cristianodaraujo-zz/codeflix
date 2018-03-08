<?php

use Illuminate\Database\Seeder;

class PlaylistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repository = app(\App\Repositories\PlaylistRepository::class);
        $thumbnails = $this->thumbnails();

        factory(\App\Models\Playlist::class, 5)->create()->each(function ($playlist) use ($repository, $thumbnails) {
            $repository->uploadThumbnail($playlist->id, $thumbnails->random());
        });
    }

    protected function thumbnails()
    {
        return new \Illuminate\Support\Collection([
            new \Illuminate\Http\UploadedFile(storage_path('app/files/faker/images/php.jpg'), 'php.jpg')
        ]);
    }
}
