<?php
namespace GameBundle\Entity;


use GameBundle\Repository\PlayerRepository;


class Base
{

    public function addBase(Player $player,PlayerRepository $repo){
        while (true) {
            $x = rand(1, 18);
            $y = rand(1, 18);

            if (!$repo->checkBase($x, $y)){
                $player->setPosX($x);
                $player->setPosY($y);
                break;
            }
        }
    }

}