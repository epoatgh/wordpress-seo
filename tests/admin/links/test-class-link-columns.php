<?php

class WPSEO_Link_Columns_Test extends WPSEO_UnitTestCase {

	/**
	 * Tests the registering of the hooks.
	 */
	public function test_register_hooks() {
		$link_columns = new WPSEO_Link_Columns();
		$link_columns->register_hooks();

		$this->assertFalse(
			has_action( 'admin_init', array( $link_columns, 'set_count_objects' ) )
		);
	}

	/**
	 * Tests the registering of the hooks of post columns.
	 */
	public function test_register_hooks_on_upload_page() {
		$GLOBALS['pagenow'] = 'upload.php';

		/** @var WPSEO_Link_Columns $link_columns */
		$link_columns = $this
			->getMockBuilder( 'WPSEO_Link_Columns' )
			->setMethods( array( 'set_post_type_hooks' ) )
			->getMock();

		$link_columns
			->expects( $this->never() )
			->method( 'set_post_type_hooks' );

		$link_columns->register_hooks();
	}

	/**
	 * Tests the registering of the hooks of post columns.
	 */
	public function test_register_hooks_on_edit_page() {
		$GLOBALS['pagenow'] = 'edit.php';

		/** @var WPSEO_Link_Columns $link_columns */

		$link_columns = new WPSEO_Link_Columns();
		$link_columns->register_hooks();

		$this->assertEquals(
			10,
			has_action( 'admin_init', array( $link_columns, 'set_count_objects' ) )
		);
	}


	/**
	 * Tests the addition of post columns.
	 */
	public function test_set_post_type_hooks() {
		/** @var WPSEO_Link_Columns $link_columns */
		$link_columns = $this
			->getMockBuilder( 'WPSEO_Link_Columns' )
			->setMethods( array( 'set_post_type_hooks' ) )
			->getMock();

		$link_columns
			->expects( $this->atLeastOnce() )
			->method( 'set_post_type_hooks' );

		$link_columns->register_hooks();
	}

	/**
	 * Tests the addition of post columns.
	 */
	public function test_add_post_columns() {
		$link_columns = new WPSEO_Link_Columns();

		$this->assertEquals(
			array( 'wpseo-links' => 'Links', 'wpseo-linked' => 'Linked' ),
			$link_columns->add_post_columns( array() )
		);
	}

	/**
	 * Test set_count_objects to set the object correctly.
	 */
	public function test_set_count_objects() {
		$link_columns = new WPSEO_Link_Columns();
		$link_columns->set_count_objects();

		$this->assertAttributeInstanceOf( 'WPSEO_Link_Column_Count', 'count_linked', $link_columns );
		$this->assertAttributeInstanceOf( 'WPSEO_Link_Column_Count', 'count_links', $link_columns );
	}

	/**
	 * Test the getting of the column content
	 */
	public function test_column_content() {
		$link_columns = new WPSEO_Link_Columns();
		$link_columns->set_count_objects();

		$link_columns->column_content( 'wpseo-links', 1 );
		$this->expectOutput( 0 );

		$link_columns->column_content( 'wpseo-linked', 1 );
		$this->expectOutput( 0 );
	}

	/**
	 * Tests column_sort.
	 */
	public function test_column_sort() {
		$link_columns = new WPSEO_Link_Columns();

		$this->assertEquals(
			array( 'wpseo-links' => 'wpseo-links', 'wpseo-linked' => 'wpseo-linked' ),
			$link_columns->column_sort( array() )
		);
	}

}