<?php

namespace Mymodule\Sender;

use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\LoaderException;
use Bitrix\Sender\Entity\Segment;
use Bitrix\Main\Loader;

class SegmentService implements Errorable
{
    /**
     * @var Segment
     */
    private Segment $entitySegment;

    /** @var ErrorCollection $errors */
    protected ErrorCollection $errors;

    /**
     * Base constructor.
     *
     * @param integer|null $id ID.
     * @param string|null $segmentName.
     * @throws LoaderException
     */
    public function __construct($id = null, $segmentName = null)
    {
        $this->errors = new ErrorCollection();

        if ( !Loader::IncludeModule('sender') )
        {
            throw new LoaderException("Module sender not installed");
        }

        $this->entitySegment = new Segment($id);
        if (!$this->entitySegment->getId())
        {
            $this->createSegment($segmentName);
        }
    }

    public function createSegment(string $segmentName): bool
    {
        $this->entitySegment
            ->set('NAME', $segmentName)
            ->set('HIDDEN', 'N')
            ->appendContactSetConnector()
            ->save();
        if ($this->entitySegment->hasErrors())
        {
            $this->errors->add($this->entitySegment->getErrorCollection()->getValues());
            return false;
        }

        return true;
    }

    public function upload(array $data): bool
    {
        $this->entitySegment->upload($data);
        if ($this->entitySegment->hasErrors())
        {
            $this->errors->add($this->entitySegment->getErrorCollection()->getValues());
            return false;
        }
        return $this->entitySegment->save();
    }

    public function getId(): int
    {
        return $this->entitySegment->getId();
    }

    public function getErrors()
    {
        return $this->errors->toArray();
    }

    public function getErrorByCode($code)
    {
        return $this->errors->getErrorByCode($code);
    }
}