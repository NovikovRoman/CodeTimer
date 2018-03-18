<?php

namespace CodeTimer;

/**
 * Class CodeTimer
 * @package CodeTimer
 */
class CodeTimer
{
    /** @var Block */
    private $globalBlock;
    private $blockCollection;

    function __construct()
    {
        $this->reset();
        $this->globalBlock = new Block('CodeTimer');
    }

    public function reset()
    {
        $this->blockCollection = [];
        return $this;
    }

    public function runBlock($name)
    {
        if (!$this->findBlock($name)) {
            $this->addBlock($name);
        }
        return $this;
    }

    public function stopBlock($name)
    {
        if ($block = $this->findBlock($name)) {
            $block->stop();
        }
        return $this;
    }

    public function blockToBrowser($name)
    {
        if ($block = $this->findBlock($name)) {
            $data = json_encode($block->asArrayShort());
        } else {
            $data = $this->errorNotFound($name);
        }
        echo '<script>console.info(\'' . $data . '\');</script>';
    }

    public function blockInfo($name, $json = false)
    {
        if ($block = $this->findBlock($name)) {
            $info = json_encode($block->asArray());
            if ($json) {
                $info = json_encode($info);
            }
            return $info;
        }
        return $this->errorNotFound($name);
    }

    public function blockPrint($name)
    {
        if ($block = $this->findBlock($name)) {
            echo $block;
        } else {
            echo $this->errorNotFound($name);
        }
        return $this;
    }

    /**
     * @param $name
     * @return Block|null
     */
    public function findBlock($name)
    {
        return empty($this->blockCollection[md5($name)]) ? null : $this->blockCollection[md5($name)];
    }

    public function checkPoint($json = false)
    {
        $this->globalBlock->stop();
        $info = json_encode($this->globalBlock->asArrayShort());
        if ($json) {
            $info = json_encode($info);
        }
        return $info;
    }

    public function checkPointToBrowser()
    {
        echo '<script>console.info(\'' . json_encode($this->checkPoint(true)) . '\');</script>';
        return $this;
    }

    private function addBlock($name)
    {
        $this->blockCollection[md5($name)] = new Block($name);
        return $this;
    }

    private function errorNotFound($name)
    {
        return 'CodeTimer: Block ' . $name . ' not found';
    }
}