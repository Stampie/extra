<?php

namespace Stampie\Extra\Util;

use Stampie\IdentityInterface;

/**
 * Stampie Identity utility functions
 *
 * @author Christophe Coevoet <stof@notk.org>
 *
 * TODO remove this class when https://github.com/henrikbjorn/Stampie/pull/16 is merged
 */
class IdentityUtils
{
    /**
     * This class should not be instantiated
     */
    private function __construct() {}

    /**
     * @param IdentityInterface[]|IdentityInterface|string $identities
     *
     * @return string
     */
    public static function formatIdentities($identities)
    {
        if (null === $identities) {
            return '';
        }

        if (is_string($identities)) {
            return $identities;
        }

        if ($identities instanceof IdentityInterface) {
            $identities = array($identities);
        }

        $stringIdentities = array();

        foreach ($identities as $identity) {
            if (null === $identity->getName()) {
                $stringIdentities[] = $identity->getEmail();
                continue;
            }

            $stringIdentities[] = sprintf('%s <%s>', $identity->getName(), $identity->getEmail());
        }

        return implode(',', $stringIdentities);
    }
}
