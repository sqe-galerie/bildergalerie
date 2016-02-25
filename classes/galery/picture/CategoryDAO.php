<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 20:16
 */
class CategoryDAO extends BaseMultiClientDAO
{

    const TABLE_NAME = "galery_categories";

    const COL_MANDANT_ID = "mandant_id";
    const COL_CATEGORY_ID = "category_id";
    const COL_CATEGORY_NAME = "category_name";
    const COL_CATEGORY_DESCRIPTION = "description";

    /**
     * CategoryDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
    }

    /**
     * Returns all categories for the current mandant.
     *
     * @return Category[]
     */
    public function getAllCategories() {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT * FROM galery_categories WHERE mandant_id =:m_id')
            ->setConditions(array("m_id" => $this->mandant->getMandantId()));

        return $this->fetchRowMany($sqlBuilder);
    }


    public function getCategoryTeasers($limit = 3) {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT * FROM bildergalerie.galery_categories AS t_cat
                        LEFT JOIN
                          (SELECT pic_id, title, path_id, category_id FROM galery_pictures
                          ORDER BY RAND()) AS t_pic ON t_pic.category_id=t_cat.category_id
                        LEFT JOIN galery_picture_path AS t_path ON t_pic.path_id=t_path.pic_path_id
                        GROUP BY t_cat.category_id LIMIT :limit;')
            ->setConditions(array('limit' => $limit));

        $rows = $this->sqlManager->fetchRowMany($sqlBuilder);
        $result = array();
        if ($this->sqlManager->getRowCount()) {
            foreach ($rows as $row) {
                $result[] = $this->row2Teaser($row);
            }
        }
        return $result;
    }

    /**
     * Creates a new category entry.
     *
     * @param Category $category
     * @return bool|int
     */
    public function createCategory(Category $category)
    {
        $data = array(
            self::COL_MANDANT_ID            => $this->mandant->getMandantId(),
            self::COL_CATEGORY_NAME         => $category->getCategoryName(),
            self::COL_CATEGORY_DESCRIPTION  => $category->getDescription()
        );

        return $this->create($data);
    }

    /**
     * Converts array representation of a category row
     * into a category object.
     *
     * @param $row
     * @return Category
     */
    protected function row2Object($row)
    {
        return new Category(
            $this->mandant,
            $this->getValueOrNull($row, self::COL_CATEGORY_ID),
            $this->getValueOrNull($row, self::COL_CATEGORY_NAME),
            $this->getValueOrNull($row, self::COL_CATEGORY_DESCRIPTION)
        );
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }

    private function row2Teaser($row)
    {
        $category = new Category($this->mandant, $row[self::COL_CATEGORY_ID], $row[self::COL_CATEGORY_NAME],
            $row[self::COL_CATEGORY_DESCRIPTION]);

        $picture = new Picture($this->mandant, $row[PictureDAO::COL_PICTURE_ID], $row[PictureDAO::COL_TITLE], $category);
        $picture->setPath(
            new PicturePath($this->mandant, $row[PicturePathDAO::COL_PIC_PATH_ID],
                $row[PicturePathDAO::COL_PATH], $row[PicturePathDAO::COL_THUMB_PATH])
        );

        return new CategoryTeaser($category, $picture);
    }
}