<?php
/**
 * This file is part of the arhitector/transcoder library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Dmitry Arhitector <dmitry.arhitector@yandex.ru>
 *
 * @license   http://opensource.org/licenses/MIT MIT
 * @copyright Copyright (c) 2017 Dmitry Arhitector <dmitry.arhitector@yandex.ru>
 */
namespace Arhitector\Transcoder\Filter;

use Arhitector\Transcoder\Format\FormatInterface;
use Arhitector\Transcoder\TimeInterval;
use Arhitector\Transcoder\TranscodeInterface;

/**
 * Class Cut.
 *
 * @package Arhitector\Transcoder\Filter
 */
class Cut implements AudioFilterInterface, FrameFilterInterface
{
	
	/**
	 * @var TimeInterval
	 */
	protected $startTime;
	
	/**
	 * @var TimeInterval
	 */
	protected $duration;
	
	/**
	 * Cut constructor.
	 *
	 * @param TimeInterval|int $start
	 * @param TimeInterval     $duration
	 *
	 * @throws \InvalidArgumentException
	 */
	public function __construct($start, TimeInterval $duration = null)
	{
		if ( ! $start instanceof TimeInterval)
		{
			$start = TimeInterval::fromSeconds($start);
		}
		
		$this->startTime = $start;
		$this->duration  = $duration;
	}
	
	/**
	 * Apply filter.
	 *
	 * @param TranscodeInterface $media
	 * @param FormatInterface    $format
	 *
	 * @return array
	 */
	public function apply(TranscodeInterface $media, FormatInterface $format)
	{
		$options = [
			'seek_start' => $this->getStartTime()->toString()
		];
		
		if ($this->getDuration() !== null)
		{
			$options['seek_end'] = $this->getDuration()->toString();
		}
		
		return $options;
	}
	
	/**
	 * Get the start time value.
	 *
	 * @return TimeInterval
	 */
	public function getStartTime()
	{
		return $this->startTime;
	}
	
	/**
	 * Get the duration value.
	 *
	 * @return TimeInterval
	 */
	public function getDuration()
	{
		return $this->duration;
	}
	
}
