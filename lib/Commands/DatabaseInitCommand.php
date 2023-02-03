<?php

namespace Felix\StudyProject\Commands;

use Felix\StudyProject\Database;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseInitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('database-init')
            ->setHelp('Инициализирует БД')
            ->setDescription('Создание файла базы данных и таблиц в ней');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     *
     * todo Написать запрос для создания таблицы
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $createTableSql = <<<SQL
        create table form (
            id INTEGER primary key AUTOINCREMENT NOT NULL,
            name_person varchar(70),
            email_person varchar(100),
            link_person varchar(400)
        );

SQL;

        try {
            $database = new Database();
            $database->query($createTableSql);
        } catch (\Throwable $throwable) {
            $output->writeln('Ошибка при инициализации базы данных: ' . $throwable->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('База данных создана и инициализирована');

        return Command::SUCCESS;
    }
}
