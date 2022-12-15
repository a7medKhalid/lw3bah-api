<?php

namespace App\Actions;

use App\Models\Section;
use App\Models\Slide;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderItems
{
    use AsAction;

    public function handle($collection, $src_id, $dest_order)
    {

        // get the slide that is being moved
        $src = $collection->find($src_id);

        // get the slide that is being moved to
        $dest = $collection->where('order', $dest_order)->first();

        $array = $collection->toArray();

        // get the index of the slide that is being moved
        $srcIndex = array_search($src->_id, array_column($array, '_id'));

        // get the index of the slide that is being moved to
        $destIndex = array_search($dest->_id, array_column($array, '_id'));

        // use splice to remove the slide that is being moved
        $removedItem = array_splice($array, $srcIndex, 1);
        // use splice to insert the slide that is being moved to the new position
        array_splice($array, $destIndex, 0, $removedItem);

      return $array;

    }
}
