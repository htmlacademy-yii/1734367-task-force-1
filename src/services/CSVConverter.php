<?php

namespace taskforce\services;

use taskforce\exceptions\ConverterException;
use SplFileObject;
use RuntimeException;
use Generator;

/**
 * Класс для конвертации CSV в SQL
 */
class CSVConverter
{
    private $path;
    private $dir;

    private $filename;
    private $headerData;
    private $fileObject;
    private $dirName;

    /**
     * Конвертирует файл CSV в SQL
     *
     * @param string $path Путь к файлу
     * @param string $dir Наименование создаваемой директории
     * @return void
     * @throws ConverterException
     */
    public function convertData(string $path, string $dir): void
    {
        $this->path = $path;
        $this->dir = $dir;

        if (!file_exists($this->path)) {
            throw new ConverterException('Файл не существует');
        }

        if (is_dir($this->path)) {
            throw new ConverterException('Необходимо указать наименование файла CSV');
        }

        try {
            $this->fileObject = new SplFileObject($this->path);
        } catch (RuntimeException $e) {
            throw new ConverterException('Не удалось открыть файл на чтение');
        }

        $this->addDirectory($this->dir);
        $this->setFileName();
        $this->setHeaderData();

        // Создаем SQL-файл
        $sqlFile = new SplFileObject($this->dirName . '/' . $this->filename . '.sql', 'w');

        foreach ($this->getNextLine() as $line) {
            $modLine = $this->modifiedArrayValue($line);

            if ($modLine === "''") {
                continue;
            }

            $data = 'INSERT INTO ' . $this->filename . ' (' . $this->headerData . ') VALUES (' . $modLine . ');' . PHP_EOL;

            if (!$sqlFile->fwrite($data)) {
                throw new ConverterException('Не удалось записать данные в файл: ' . $this->filename . '.sql');
            }
        }
    }

    /**
     * Устанавливает заголовки из файла
     *
     * @return void
     */
    private function setHeaderData(): void
    {
        $this->fileObject->rewind();

        $this->headerData = $this->modifiedArrayValue($this->fileObject->fgetcsv());
    }

    /**
     * Возвращает строку из файла
     *
     * @return Generator|null
     */
    private function getNextLine(): ?Generator
    {
        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }

        return null;
    }

    /**
     * Создает директорию
     *
     * @param string $dir Наименование директории
     * @return void
     * @throws ConverterException
     */
    private function addDirectory(string $dir): void
    {
        $this->dirName = dirname($this->path) . '/' . $dir;
        if (!file_exists($this->dirName) && !mkdir($this->dirName)) {
            throw new ConverterException('Не удалось создать директорию ' . $dir);
        }
    }

    /**
     * Устанавливает наименование SQL-файла
     *
     * @return void
     */
    private function setFileName(): void
    {
        $pathData = explode('/', $this->path);
        $csvFileNameData = explode('.', end($pathData));

        $this->filename = $csvFileNameData[0];
    }

    /**
     * Обрамляет элементы массива в кавычки и преобразует в строку
     *
     * @param array $data Массив данных
     * @return string
     */
    private function modifiedArrayValue(array $data): string
    {
        $modData = array_map(
            function ($value) {
                // Удаляем все непечатаемые символы в строке
                $value = preg_replace('/[^\P{C}]+/u','', $value);
                return "'$value'";
            },
            $data
        );

        return implode(', ', $modData);
    }

}
