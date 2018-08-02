<?php

namespace Tests\Feature;

use Tests\TestCase;

class FarsiRequestTest extends TestCase
{
    /**
     * A basic test example.
     * @return void
     */
    public function testAr2FaAutoReplaceTest()
    {
        $response = $this->get('/?test=يكة٤٥٦');

        $response->assertStatus(200);
        $response->assertSee("یکه۴۵۶");
    }

    public function testRequestFieldReplaceTest()
    {
        $response = $this->get('/form?phone_number=+۹۸۹۱۲۰۰۰۰۰۰۰&post_content=قرن 21');

        $response->assertStatus(200);
        $response->assertSee("phone_number=989120000000");
        $response->assertSee("post_content=قرن ۲۱");
    }
}
