<?php
namespace Emma\Security\Access\Interfaces;

/**
 * @Author: Ademola Aina
 * Email: debascoguy@gmail.com
 */
interface PrivilegeInterface
{
    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): static;

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static;

    /**
     * @return string|null
     */
    public function getName(): ?string;

}