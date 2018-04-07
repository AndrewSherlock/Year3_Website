<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 07/04/2018
 * Time: 16:51
 */

namespace App\Tests;

use App\Entity\Review;
use App\Entity\SuggestedReview;
use PHPUnit\Framework\TestCase;

class SuggestedReviewTest extends TestCase
{
    public function testSuggestedReview()
    {
        $suggested = new SuggestedReview();

        $suggested->setReview(new Review());

        $this->assertNull($suggested->getId());
        $this->assertNotNull($suggested->getReview());
    }
}