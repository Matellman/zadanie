<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

use App\Hotel;
use App\Comment;
use App\SubComment;
use App\KnowFromSelect;

/**
*   routing:
*   'store_comments'
*   'edit_comments' -> comment_id
*   'store_subcomments' -> comment_id
*   'show_comments' -> hotel_id
*   'delete_comments' -> comment_id
*/

class MainTest extends TestCase
{   
    /**
     *  Dodanie przykladowych hoteli
     *
     * @return void
     */
    public function testDatabase()     
    {
        Artisan::call('migrate');
        factory(App\Hotel::class, 1)->create();
    }
    
    
    /**
     *  Test zapisu nowej opini
     *  - odpowiedź serwera
     *  - sprawdzenie statusu json
     *
     * @return void
     */
    public function testStoreComment()   
    { 
        $random_hotel = Hotel::orderBy(DB::raw('RAND()'))->take(1)->get();
        $random_know_from = KnowFromSelect::orderBy(DB::raw('RAND()'))->take(1)->get();
        
        $random_comment_data = factory(App\Comment::class)->make([
            'hotel_id' => $random_hotel[0]->id,
            'know_from' => $random_know_from[0]->id
        ]);

        $this->post(route('store_comments', [$random_hotel[0]->id]), [
            'comment' => $random_comment_data->comment,
            'rating' => $random_comment_data->rating,
            'hotel_id' => $random_comment_data->hotel_id,
            'know_from' => $random_comment_data->know_from        
        ]);
            
        $this->assertResponseOk();
        $this->seeJsonEquals(['status' => 'success']);
    }
    
    
    /**
     *  Test edycji opini
     *  - odpowiedź serwera
     *  - sprawdzenie statusu json
     *
     * @return void
     */
    public function testEditComment()   
    { 
        $random_comment = Comment::orderBy(DB::raw('RAND()'))->take(1)->get();
        
        $this->patch(route('edit_comments', [$random_comment[0]->id]), [
            'comment' => 'Test test test',     
        ]);
            
        $this->assertResponseOk();
        $this->seeJsonEquals(['status' => 'success']);
    }
    
    
    /**
     *  Test dodania komentarza
     *  - odpowiedź serwera
     *  - sprawdzenie statusu json
     *
     * @return void
     */
    public function testStoreSubComment()   
    { 
        $random_comment = Comment::orderBy(DB::raw('RAND()'))->take(1)->get();
        
        $random_sub_comment_data = factory(App\SubComment::class)->make([
            'comment_id' =>  $random_comment[0]->id,
        ]);
        
        $this->post(route('store_subcomments', [$random_comment[0]->id]), [
            'comment_id' =>  $random_sub_comment_data->comment_id,
            'comment' => $random_sub_comment_data->comment,  
        ]);
            
        $this->assertResponseOk();
        $this->seeJsonEquals(['status' => 'success']);
    }
    
    
    /**
     *  Test pobieranie opini z komentarzami
     *  - odpowiedź serwera
     *  - sprawdzenie json
     *
     * @return void
     */
    public function testGetComment()   
    { 
        $random_hotel = Hotel::orderBy(DB::raw('RAND()'))->take(1)->get();

        $json_response = $this->get(route('show_comments', [$random_hotel[0]->id]));
        
        $this->assertResponseOk();
        
        $json_response = $this->response->getContent();
        $json_response = json_decode($json_response);
        
        $correct = false; 

        if($json_response){
            
            $return = array_key_exists('comments', $json_response) ? true : false;
            
            if($return){
                $return = !empty($json_response->comments[0]->sub_comments) ? true : false;    
            }
            else{
                $return = false;    
            };
  
           $correct = $return; 
        };
         
        $this->assertTrue($correct); 
    }
    
    
    /**
     *  Test usuwania opini z komentarzami
     *  - odpowiedź serwera
     *  - sprawdzenie statusu json
     *  - sprawdzenie czy opinia i komentarz zostaly usuniete
     *
     * @return void
     */
    public function testRemoveComment()   
    { 
        $random_comment = Comment::orderBy(DB::raw('RAND()'))->take(1)->get();

        $this->delete(route('delete_comments', [$random_comment[0]->id]));
            
        $this->assertResponseOk();
        $this->seeJsonEquals(['status' => 'success']);
        
        $comments = Comment::get();
        $sub_comments = SubComment::get();
        
        $correct = $comments->count() ? false : true;
        $correct = $sub_comments->count() ? false : true;   
        
        $this->assertTrue($correct); 
    }
    
    
    /**
     *  Wyczyszczenie tabeli
     *
     * @return void
     */
    public function testEndDatabase()     
    {
        Artisan::call('migrate:reset');
    }
}