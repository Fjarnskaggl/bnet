<?php

/*
 * This file is part of the Battle.net API Client package.
 *
 * (c) Jonas Stendahl <jonas@stendahl.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pwnraid\Bnet\Warcraft\Guilds;

use Pwnraid\Bnet\Core\AbstractRequest;
use Pwnraid\Bnet\Utils;

class GuildRequest extends AbstractRequest
{
    protected $realm;

    public function achievements()
    {
        $data = $this->client->get('data/guild/achievements');

        return new AchievementEntity($data);
    }

    public function find($name, array $fields = [])
    {
        if ($this->realm === null) {
            throw new \RuntimeException('You must set a realm name with on() before calling find()');
        }

        $data = $this->client->get('guild/'.$this->realm.'/'.$name, ['query' => ['fields' => implode(',', $fields)]]);

        if ($data === null) {
            return;
        }

        return new GuildEntity($data);
    }

    public function on($realm)
    {
        $this->realm = Utils::realmNameToSlug($realm);

        return $this;
    }

    public function perks()
    {
        $data = $this->client->get('data/guild/perks');

        return new PerkEntity($data);
    }

    public function rewards()
    {
        $data = $this->client->get('data/guild/rewards');

        return new RewardEntity($data);
    }
}
