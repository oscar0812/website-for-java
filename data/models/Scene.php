<?php

use Base\Scene as BaseScene;

/**
 * Skeleton subclass for representing a row from the 'scene' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Scene extends BaseScene
{
    public function getParentScene()
    {
        return \SceneQuery::create()->findOneBySceneId($this->getParentSceneId());
    }
    
    public static function orderPlacement($id, $newIndex)
    {
        $scenes = \SceneQuery::create()->orderByPlacement()->find();

        $index = 1;
        foreach ($scenes as $scene) {
            if ($newIndex == $index && $scene->getId() != $id) {
                // this is were the item is supposed to go, so just place the item
                // we are looking at in the next index
                $scene->setPlacement(++$index);
            }
            if ($scene->getId() == $id) {
                // found the item we were looking for
                $scene->setPlacement($newIndex);
                if ($newIndex <= $index) {
                    // if we moved item back we have to increment the index to
                    // push other elements one back
                    $index++;
                }
            } else {
                // base case, just set index as incremental
                $scene->setPlacement($index++);
            }
        }

        $scenes->save();
    }
}
