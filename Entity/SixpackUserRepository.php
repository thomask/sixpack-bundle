<?php

namespace Peerj\Bundle\SixPackBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Types\Type as DoctrineType;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Peerj\Bundle\SixPackBundle\Entity\SixpackUser;

/**
 * SixpackUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SixpackUserRepository extends EntityRepository
{
    /**
     * Finds all client_ids for a user
     *
     * @param $user
     *
     * @return array|null
     */
    public function findAllByUser($user)
    {
        return $this->findAllByUserId($user->getId());
    }

    /**
     * Finds all client_ids for a user
     *
     * @param $user
     *
     * @return array|null
     */
    public function findAllByUserId($user_id)
    {
        /*
        $query = $em->createQuery('select spu.* from SixpackUser spu Join User u on spu.user = u.id where u.id = :user_id');
        $query = $this->createQueryBuilder()
            ->select('spu')
            ->from('SixPackUser', 'spu')
            ->join('spu.User', 'u', Expr\Join::With, 'spu.user_id = u.id')
            ->where('u.id = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery();
        */
        $query = $this->createQueryBuilder('spu')
                 ->where('spu.user = :user_id')
                 ->setParameter('user_id', $user_id)
                 ->getQuery();
        
        return $query->getResult();
    }

    public function findAllAssociatedClients($clientId)
    {
        $record = $this->findOneBy(array('client_id' => $clientId));
        $user_id = $record->getUser()->getId();

        return $this->findAllByUserId($user_id);
    }
}