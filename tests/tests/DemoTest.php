<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;

class DemoTest extends TestCase
{
    /**
     * @test
     */
    public function testWillExpireAt()
    {
        // set base time
        $base_time = Carbon::createFromTimestamp( time() );

        
        // Test conditions here        
        // If difference is less than or equal to 24 hrs then output must be base time + 90 minutes
        // formatted to minute ('YmdHm') since execution of this code might go beyond a second
        // and the default Y-m-d H:i:s format will cause unwarranted failures
        

        $test_time = Carbon::parse( $base_time )->addHour();
        $result = DTApi\Helpers\TeHelper::willExpireAt( $test_time, $base_time);
        $this->assertEquals( $base_time->addMinutes( 90 )->format( 'YmdHm'), $result->format( 'YmdHm') );

        $test_time = Carbon::parse( $base_time )->addHour( 24 );
        $result = DTApi\Helpers\TeHelper::willExpireAt( $test_time, $base_time);
        $this->assertEquals( $base_time->addMinutes( 90 )->format( 'YmdHm') , $result->format( 'YmdHm') );

        // if difference is between 24 hrs and 72 hrs then output must be base time + 16 hours
        $test_time = Carbon::parse( $base_time )->addHour( 25 );
        $result = DTApi\Helpers\TeHelper::willExpireAt( $test_time, $base_time);
        $this->assertEquals( $base_time->addHours( 16 )->format( 'YmdHm') , $result->format( 'YmdHm' ) );

        $test_time = Carbon::parse( $base_time )->addHour( 72 );
        $result = DTApi\Helpers\TeHelper::willExpireAt( $test_time, $base_time);
        $this->assertEquals( $base_time->addHours( 16 )->format( 'YmdHm') , $result->format( 'YmdHm') );

        // if difference is more than 72 hrs but less than or equal 90 hrs then output must be test time
        $test_time = Carbon::parse( $base_time )->addHour( 73 );
        $result = DTApi\Helpers\TeHelper::willExpireAt( $test_time, $base_time);
        $this->assertEquals( $test_time , $result );

        $test_time = Carbon::parse( $base_time )->addHour( 90 );
        $result = DTApi\Helpers\TeHelper::willExpireAt( $test_time, $base_time);
        $this->assertEquals( $test_time , $result );

        //if test time is before base time the output must be in the past
        $test_time = Carbon::parse( $base_time )->subHours( 24 );
        $result = DTApi\Helpers\TeHelper::willExpireAt( $test_time, $base_time);
        $this->assertEquals( $base_time->subHours( 16 ) , $result );

    }

}
