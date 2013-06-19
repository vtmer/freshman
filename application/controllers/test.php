<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

require_once(VENDORPATH . 'autoload.php');
require_once('backend/auth.php');

/*
 * Test Controller
 *
 * 生成测试数据
 */
class Test extends Auth_Controller {
    private $faker;
    private $category_count = 4;
    private $tag_count = 15;
    private $author_count = 5;

    public function __construct() {
        parent::__construct();

        $this->faker = Faker\Factory::create();

        $this->load->model('post_model');
        $this->load->model('tag_model');
        $this->load->model('site_metas_model');
        $this->load->model('user_model');

        $this->post_model->db
            ->empty_table('posts_categories');
        $this->post_model->db
            ->empty_table('posts_tags');
        $this->post_model->db
            ->empty_table('post_metas');
        $this->post_model->db
            ->empty_table('posts');
        $this->user_model->db
            ->where('user_id > ', 1)
            ->delete('users_roles');
        $this->user_model->db
            ->where('id > ', 1)
            ->delete('users');
    }

    public function index() {
        echo 'start';

        $this->create_tags($this->tag_count);
        $this->create_posts();

        echo 'ok';
    }

    private function create_posts($limit = 50, $tags_limit = 3) {
        for ($i = 0;$i < $limit;$i += 1) {
            $post = $this->post_model->create(array(
                'title' => $this->faker->word(25),
                'content' => $this->faker->text(2500),
                'status' => 1,
                'author_id' => 1
            ));
            $this->post_model->update_categories($post->id,
                [rand() % $this->category_count + 1]);

            $tags = array();
            for ($j = 0;$j < $tags_limit;$j += 1) {
                $tags[] = $this->tag_model
                    ->get_by_id(rand() % $this->tag_count + 1)[0]->name;
            }
            $this->post_model->update_tags($post->id, $tags);

            $campus = array();
            foreach ($this->site_metas_model->get('campus') as $c) {
                $campus[] = $c->value;
            }
            $this->post_model->update_campus($post->id,
                [$campus[rand() % sizeof($campus)]]);
        }
    }

    private function create_tags($limit = 15) {
        for ($i = 0;$i < $limit;$i += 1) {
            $this->tag_model
                ->create($this->faker->word(2) . $this->faker->word(3));
        }
        return $limit;
    }

    private function create_users($limit = 5) {
        for ($i = 0;$i < $limit;$i += 1) {
            $this->user_model->create($this->faker->name, $this->faker->name,
                                      '123', [2]);
        }
    }
}
