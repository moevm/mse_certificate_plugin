<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * File contains the unit tests for the element helper class.
 *
 * @package    mod_customcert
 * @category   test
 * @copyright  2017 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * Unit tests for the element helper class.
 *
 * @package    mod_customcert
 * @category   test
 * @copyright  2017 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 class mod_customcert_element_testcase extends advanced_testcase {

    /**
     * Test set up.
     */
    public function setUp() {
        $this->resetAfterTest();
    }

   /**
     * Test return the correct name added element.
     */
    public function test_adding_one_element() {
        global $DB;

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Create a custom certificate in the course.
        $customcert = $this->getDataGenerator()->create_module('customcert', array('course' => $course->id));

        // Get the template to add elements to.
        $template = $DB->get_record('customcert_templates', array('contextid' => context_module::instance($customcert->cmid)->id));
        $template = new \mod_customcert\template($template);

        // Add a page to the template.
        $pageid = $template->add_page();

		$data = new \stdClass();
		$data->name = "test";
		$data->pageid = $pageid;
		$data->element = "text";
		$data->width = 10;
		$data->text = "Test text";

		if ($e = \mod_customcert\element_factory::get_element_instance($data)) {
        	$e->save_form_elements($data);
    	}
	
		$element = $DB->get_record('customcert_elements', ['sequence' => '1']);

		$this->assertEquals("test", $element->name);
    }

	 /**
     * Test return the correct names added elements.
     */
    public function test_adding_two_elements() {
        global $DB;

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Create a custom certificate in the course.
        $customcert = $this->getDataGenerator()->create_module('customcert', array('course' => $course->id));

        // Get the template to add elements to.
        $template = $DB->get_record('customcert_templates', array('contextid' => context_module::instance($customcert->cmid)->id));
        $template = new \mod_customcert\template($template);

        // Add a page to the template.
        $pageid = $template->add_page();

		$data = new \stdClass();
		$data->name = "test";
		$data->pageid = $pageid;
		$data->element = "text";
		$data->width = 10;
		$data->text = "Text";

		$count = 2;

		if ($e = \mod_customcert\element_factory::get_element_instance($data)) {
        	$e->save_form_elements($data, $count);
    	}
	
		$element1 = $DB->get_record('customcert_elements', ['sequence' => '1']);
		$element2 = $DB->get_record('customcert_elements', ['sequence' => '2']);

		$this->assertEquals("test", $element1->name);
		$this->assertEquals("test", $element2->name);
    }
    
    /**
     * Test return the correct names added aligned elements and correct posx.
     */
    public function test_adding_two_aligned_elements() {
        global $DB;

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Create a custom certificate in the course.
        $customcert = $this->getDataGenerator()->create_module('customcert', array('course' => $course->id));

        // Get the template to add elements to.
        $template = $DB->get_record('customcert_templates', array('contextid' => context_module::instance($customcert->cmid)->id));
        $template = new \mod_customcert\template($template);

        // Add a page to the template.
        $pageid = $template->add_page();

		$data = new \stdClass();
		$data->name = "test";
		$data->pageid = $pageid;
		$data->element = "text";
		$data->width = 10;
		$data->text = "Text";
		
		$needalign = 1;
		$count = 2;

		if ($e = \mod_customcert\element_factory::get_element_instance($data)) {
        	$e->save_form_elements($data, $count, $needalign);
    	}
	
		$element1 = $DB->get_record('customcert_elements', ['sequence' => '1']);
		$element2 = $DB->get_record('customcert_elements', ['sequence' => '2']);

		$this->assertEquals("test", $element1->name);
		$this->assertEquals("test", $element2->name);
		$this->assertEquals(0, $element1->posx);
		$this->assertEquals(10, $element2->posx);
    }
    
    /**
     * Test return the correct names added aligned elements and correct posx.
     */
    public function test_adding_three_aligned_elements() {
        global $DB;

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Create a custom certificate in the course.
        $customcert = $this->getDataGenerator()->create_module('customcert', array('course' => $course->id));

        // Get the template to add elements to.
        $template = $DB->get_record('customcert_templates', array('contextid' => context_module::instance($customcert->cmid)->id));
        $template = new \mod_customcert\template($template);

        // Add a page to the template.
        $pageid = $template->add_page();

		$data = new \stdClass();
		$data->name = "test";
		$data->pageid = $pageid;
		$data->element = "text";
		$data->width = 20;
		$data->text = "Text";
		
		$needalign = 1;
		$count = 3;

		if ($e = \mod_customcert\element_factory::get_element_instance($data)) {
        	$e->save_form_elements($data, $count, $needalign); //, $count, $needalign, $aligntype);
    	}
	
		$element1 = $DB->get_record('customcert_elements', ['sequence' => '1']);
		$element2 = $DB->get_record('customcert_elements', ['sequence' => '2']);
		$element3 = $DB->get_record('customcert_elements', ['sequence' => '3']);

		$this->assertEquals("test", $element1->name);
		$this->assertEquals("test", $element2->name);
		$this->assertEquals("test", $element3->name);
		$this->assertEquals(0, $element1->posx);
		$this->assertEquals(20, $element2->posx);
		$this->assertEquals(40, $element3->posx);
    }
    
    /**
     * Test return the correct names added elements and correct posx.
     */
    public function test_adding_two_aligned_elements_when_state_of_alignment_off() {
        global $DB;

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Create a custom certificate in the course.
        $customcert = $this->getDataGenerator()->create_module('customcert', array('course' => $course->id));

        // Get the template to add elements to.
        $template = $DB->get_record('customcert_templates', array('contextid' => context_module::instance($customcert->cmid)->id));
        $template = new \mod_customcert\template($template);

        // Add a page to the template.
        $pageid = $template->add_page();

		$data = new \stdClass();
		$data->name = "test";
		$data->pageid = $pageid;
		$data->element = "text";
		$data->width = 10;
		$data->text = "Text";
		
		$needalign = 0;
		$count = 2;

		if ($e = \mod_customcert\element_factory::get_element_instance($data)) {
        	$e->save_form_elements($data, $count, $needalign);
    	}
	
		$element1 = $DB->get_record('customcert_elements', ['sequence' => '1']);
		$element2 = $DB->get_record('customcert_elements', ['sequence' => '2']);

		$this->assertEquals("test", $element1->name);
		$this->assertEquals("test", $element2->name);
		$this->assertEquals(0, $element1->posx);
		$this->assertEquals(0, $element2->posx);
    }
    
    /**
     * Test return the correct names added aligned elements and correct posx.
     */
    public function test_adding_two_aligned_elements_to_center() {
        global $DB;

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Create a custom certificate in the course.
        $customcert = $this->getDataGenerator()->create_module('customcert', array('course' => $course->id));

        // Get the template to add elements to.
        $template = $DB->get_record('customcert_templates', array('contextid' => context_module::instance($customcert->cmid)->id));
        $template = new \mod_customcert\template($template);

        // Add a page to the template.
        $pageid = $template->add_page();

		$data = new \stdClass();
		$data->name = "test";
		$data->pageid = $pageid;
		$data->element = "text";
		$data->width = 20;
		$data->text = "Text";
		$data->posx = 40;
		$data->posy = 40;
		
		$needalign = 1;
		$count = 2;
		$aligntype = "center";

		if ($e = \mod_customcert\element_factory::get_element_instance($data)) {
        	$e->save_form_elements($data, $count, $needalign, $aligntype);
    	}
	
		$element1 = $DB->get_record('customcert_elements', ['sequence' => '1']);
		$element2 = $DB->get_record('customcert_elements', ['sequence' => '2']);

		$this->assertEquals("test", $element1->name);
		$this->assertEquals("test", $element2->name);
		$this->assertEquals(20, $element1->posx);
		$this->assertEquals(40, $element2->posx);
    }
    
    /**
     * Test return the correct names added aligned elements and correct posx.
     */
    public function test_adding_two_aligned_elements_to_right() {
        global $DB;

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Create a custom certificate in the course.
        $customcert = $this->getDataGenerator()->create_module('customcert', array('course' => $course->id));

        // Get the template to add elements to.
        $template = $DB->get_record('customcert_templates', array('contextid' => context_module::instance($customcert->cmid)->id));
        $template = new \mod_customcert\template($template);

        // Add a page to the template.
        $pageid = $template->add_page();

		$data = new \stdClass();
		$data->name = "test";
		$data->pageid = $pageid;
		$data->element = "text";
		$data->width = 20;
		$data->text = "Text";
		$data->posx = 40;
		$data->posy = 40;
		
		$needalign = 1;
		$count = 2;
		$aligntype = "right";

		if ($e = \mod_customcert\element_factory::get_element_instance($data)) {
        	$e->save_form_elements($data, $count, $needalign, $aligntype);
    	}
	
		$element1 = $DB->get_record('customcert_elements', ['sequence' => '1']);
		$element2 = $DB->get_record('customcert_elements', ['sequence' => '2']);

		$this->assertEquals("test", $element1->name);
		$this->assertEquals("test", $element2->name);
		$this->assertEquals(0, $element1->posx);
		$this->assertEquals(20, $element2->posx);
    }
    
    /**
     * Test return the correct names added aligned elements and correct posx.
     */
    public function test_out_of_bounds_when_adding_three_aligned_elements_to_right() {
        global $DB;

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Create a custom certificate in the course.
        $customcert = $this->getDataGenerator()->create_module('customcert', array('course' => $course->id));

        // Get the template to add elements to.
        $template = $DB->get_record('customcert_templates', array('contextid' => context_module::instance($customcert->cmid)->id));
        $template = new \mod_customcert\template($template);

        // Add a page to the template.
        $pageid = $template->add_page();

		$data = new \stdClass();
		$data->name = "test";
		$data->pageid = $pageid;
		$data->element = "text";
		$data->width = 30;
		$data->text = "Text";
		$data->posx = 40;
		$data->posy = 40;
		
		$needalign = 1;
		$count = 3;
		$aligntype = "right";

		if ($e = \mod_customcert\element_factory::get_element_instance($data)) {
        	$e->save_form_elements($data, $count, $needalign, $aligntype);
    	}
	
		$element1 = $DB->get_record('customcert_elements', ['sequence' => '1']);
		$element2 = $DB->get_record('customcert_elements', ['sequence' => '2']);
		$element3 = $DB->get_record('customcert_elements', ['sequence' => '3']);

		$this->assertEquals("test", $element1->name);
		$this->assertEquals("test", $element2->name);
		$this->assertEquals("test", $element3->name);
		$this->assertEquals(0, $element1->posx);
		$this->assertEquals(30, $element2->posx);
		$this->assertEquals(60, $element3->posx);
    }
    
    /**
     * Test return the correct names added aligned elements and correct posx.
     */
    public function test_out_of_bounds_when_adding_three_aligned_elements_to_center() {
        global $DB;

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Create a custom certificate in the course.
        $customcert = $this->getDataGenerator()->create_module('customcert', array('course' => $course->id));

        // Get the template to add elements to.
        $template = $DB->get_record('customcert_templates', array('contextid' => context_module::instance($customcert->cmid)->id));
        $template = new \mod_customcert\template($template);

        // Add a page to the template.
        $pageid = $template->add_page();

		$data = new \stdClass();
		$data->name = "test";
		$data->pageid = $pageid;
		$data->element = "text";
		$data->width = 30;
		$data->text = "Text";
		$data->posx = 30;
		$data->posy = 30;
		
		$needalign = 1;
		$count = 3;
		$aligntype = "center";

		if ($e = \mod_customcert\element_factory::get_element_instance($data)) {
        	$e->save_form_elements($data, $count, $needalign, $aligntype);
    	}
	
		$element1 = $DB->get_record('customcert_elements', ['sequence' => '1']);
		$element2 = $DB->get_record('customcert_elements', ['sequence' => '2']);
		$element3 = $DB->get_record('customcert_elements', ['sequence' => '3']);

		$this->assertEquals("test", $element1->name);
		$this->assertEquals("test", $element2->name);
		$this->assertEquals("test", $element3->name);
		$this->assertEquals(0, $element1->posx);
		$this->assertEquals(30, $element2->posx);
		$this->assertEquals(60, $element3->posx);
    }
    
    

}
