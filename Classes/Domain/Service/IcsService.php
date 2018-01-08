<?php
namespace ChriWo\Staffholiday\Domain\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 - 2018 Christian Wolfram <c.wolfram@chriwo.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * IcsService
 *
 * @author Jake Bellacera
 * @see https://gist.github.com/jakebellacera/635416
 */
class IcsService
{
    const DT_FORMAT = 'Ymd\THis';

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @var array
     */
    private $availableProperties = [
        'description',
        'dtend',
        'dtstart',
        'location',
        'summary',
        'url',
    ];

    /**
     * IcsService constructor.
     *
     * @param string|array $props
     * @return void
     */
    public function __construct($props)
    {
        $this->set($props);
    }

    /**
     *
     * @param string|array $key
     * @param mixed $val
     * @return void
     */
    public function set($key, $val = false)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
        } else {
            if (in_array($key, $this->availableProperties, true)) {
                $this->properties[$key] = $this->sanitizeVal($val, $key);
            }
        }
    }

    /**
     *
     * @return string
     */
    public function toString()
    {
        $rows = $this->buildProps();
        return implode("\r\n", $rows);
    }

    /**
     *
     * @return array
     */
    private function buildProps()
    {
        // Build ICS properties - add header
        $icsProps = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//TYPO3 Extension staffholiday//EN',
            'CALSCALE:GREGORIAN',
            'BEGIN:VEVENT',
        ];

        // Build ICS properties - add header
        $props = [];
        foreach ($this->properties as $k => $v) {
            $key = $k;
            switch ($key) {
                case 'url':
                    $key .= ';VALUE=URI';
                    break;
                case 'dtend':
                case 'dtstart':
                    $key .= ';TZID=' . date_default_timezone_get();
                    break;
                default:
            }

            $props[strtoupper($key)] = $v;
        }

        // Set some default values
        $props['DTSTAMP'] = $this->formatTimestamp('now');
        $props['UID'] = uniqid();

        // Append properties
        foreach ($props as $k => $v) {
            $icsProps[] = "$k:$v";
        }

        // Build ICS properties - add footer
        $icsProps[] = 'END:VEVENT';
        $icsProps[] = 'END:VCALENDAR';

        return $icsProps;
    }

    /**
     *
     * @param mixed $val
     * @param mixed $key
     * @return null|string|string[]
     */
    private function sanitizeVal($val, $key = false)
    {
        switch ($key) {
            case 'dtstamp':
            case 'dtend':
            case 'dtstart':
                $val = $this->formatTimestamp($val);
                break;
            default:
                $val = $this->escapeString($val);
        }

        return $val;
    }

    /**
     *
     * @param \DateTime|string $timestamp
     * @return mixed
     */
    private function formatTimestamp($timestamp)
    {
        $dateTime = $timestamp;
        if (!$timestamp instanceof \DateTime) {
            $dateTime = new \DateTime($timestamp);
        }

        return $dateTime->format(self::DT_FORMAT);
    }

    /**
     *
     * @param string $str
     * @return null|string|string[]
     */
    private function escapeString($str)
    {
        return preg_replace('/([\,;])/', '\\\$1', $str);
    }
}
