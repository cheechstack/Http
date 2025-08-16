<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Cheechstack\Http\Request;

final class RequestTest extends TestCase {

    /** Generate a mock Request object for use within the testing suite 
    *
    * @return Request
    */
    private function createTestRequest() : Request {
        return Request::createForTest(
            "https://www.example.com/test/case?this=is&my=test",
            "127.0.0.1",
            "GET",
            "this=is&me=1"
        ); 
    }

    public function testCanParseURI() : void {
        $request = $this->createTestRequest();

        $this->assertSame(
            "/test/case",
            $request->getRequestURI()
        );
    }

    public function testCanParseQueryParameters() : void {
        $r = $this->createTestRequest();
        $actual = $r->getQueryParameters();
        $expected = [
            "this" => "is",
            "my" => "test"  
        ];

        $this->assertNotEmpty($actual);
        $this->assertContainsOnlyArray($actual);
        $this->assertArrayIsEqualToArrayIgnoringListOfKeys(
            $expected, $actual, []
        );
    }
}
