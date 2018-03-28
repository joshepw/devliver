<?php

namespace Shapecode\Devliver\Service;

use Github\Client;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Class GitHubRelease
 *
 * @package Shapecode\Devliver\Service
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class GitHubRelease
{

    /** @var Client */
    protected $client;

    /** @var AdapterInterface */
    protected $cache;

    /** @var */
    protected $currentRelease;

    /**
     * @param Client            $client
     * @param AdapterInterface  $cache
     * @param                   $currentRelease
     */
    public function __construct(Client $client, AdapterInterface $cache, $currentRelease)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->currentRelease = $currentRelease;
    }

    /**
     * @return array
     */
    public function getLatestRelease()
    {
        return $this->getAllReleases()[0];
    }

    /**
     * @return array
     */
    public function getCurrentRelease()
    {
        foreach ($this->getAllReleases() as $release) {
            if ($release['name'] == $this->currentRelease) {
                return $release;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getAllReleases()
    {
        $cachedReleases = $this->cache->getItem('devliver_releases');

        if ($cachedReleases->isHit()) {
            return $cachedReleases->get();
        }

        $releases = $this->client->api('repo')->releases()->all('shapecode', 'devliver');

        $cachedReleases->set($releases);
        $cachedReleases->expiresAfter(86400);

        $this->cache->save($cachedReleases);

        return $releases;
    }
}
