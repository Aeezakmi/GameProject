<?php

namespace GameBundle\Repository;


class PlayerRepository extends \Doctrine\ORM\EntityRepository
{
    public function checkBase($posX, $posY){
        return $this->createQueryBuilder('players')
            ->Where('players.posX = :posX')
            ->andWhere('players.posY = :posY')
            ->setParameter('posX', $posX)
            ->setParameter('posY', $posY)
            ->getQuery()
            ->execute();
    }


}
