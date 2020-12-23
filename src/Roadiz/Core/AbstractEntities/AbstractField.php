<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;
use RZ\Roadiz\Core\Entities\NodeTypeField;
use RZ\Roadiz\Utils\StringHandler;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\MappedSuperclass
 * @ORM\Table(indexes={
 *     @ORM\Index(columns={"position"}),
 *     @ORM\Index(columns={"group_name"}),
 *     @ORM\Index(columns={"group_name_canonical"})
 * })
 * @Serializer\ExclusionPolicy("all")
 */
abstract class AbstractField extends AbstractPositioned
{
    /**
     * String field is a simple 255 characters long text.
     */
    const STRING_T = 0;
    /**
     * DateTime field is a combined Date and Time.
     *
     * @see \DateTime
     */
    const DATETIME_T = 1;
    /**
     * Text field is a 65000 characters long text.
     */
    const TEXT_T = 2;
    /**
     * Richtext field is an HTML text using a WYSIWYG editor.
     *
     * Use Markdown type instead. WYSIWYG is evil.
     */
    const RICHTEXT_T = 3;
    /**
     * Markdown field is a pseudo-coded text which is render
     * with a simple editor.
     */
    const MARKDOWN_T = 4;
    /**
     * Boolean field is a simple switch between 0 and 1.
     */
    const BOOLEAN_T = 5;
    /**
     * Integer field is a non-floating number.
     */
    const INTEGER_T = 6;
    /**
     * Decimal field is a floating number.
     */
    const DECIMAL_T = 7;
    /**
     * Email field is a short text which must
     * comply with email rules.
     */
    const EMAIL_T = 8;
    /**
     * Documents field helps linking NodesSources with Documents.
     */
    const DOCUMENTS_T = 9;
    /**
     * Password field is a simple text data rendered
     * as a password input with a confirmation.
     */
    const PASSWORD_T = 10;
    /**
     * Colour field is an hexadecimal string which is rendered
     * with a colour chooser.
     */
    const COLOUR_T = 11;
    /**
     * Geotag field is a Map widget which stores
     * a Latitude and Longitude as an array.
     */
    const GEOTAG_T = 12;
    /**
     * Nodes field helps linking Nodes with other Nodes entities.
     */
    const NODES_T = 13;
    /**
     * Nodes field helps linking NodesSources with Users entities.
     */
    const USER_T = 14;
    /**
     * Enum field is a simple select box with default values.
     */
    const ENUM_T = 15;
    /**
     * Children field is a virtual field, it will only display a
     * NodeTreeWidget to show current Node children.
     */
    const CHILDREN_T = 16;
    /**
     * Nodes field helps linking Nodes with CustomForms entities.
     */
    const CUSTOM_FORMS_T = 17;
    /**
     * Multiple field is a simple select box with multiple choices.
     */
    const MULTIPLE_T = 18;
    /**
     * Radio group field is like ENUM_T but rendered as a radio
     * button group.
     */
    const RADIO_GROUP_T = 19;
    /**
     * Check group field is like MULTIPLE_T but rendered as
     * a checkbox group.
     */
    const CHECK_GROUP_T = 20;
    /**
     * Multi-Geotag field is a Map widget which stores
     * multiple Latitude and Longitude with names and icon options.
     */
    const MULTI_GEOTAG_T = 21;
    /**
     * @see \DateTime
     */
    const DATE_T = 22;
    /**
     * Textarea to write Json syntaxed code
     */
    const JSON_T = 23;
    /**
     * Textarea to write CSS syntaxed code
     */
    const CSS_T = 24;
    /**
     * Selectbox to choose ISO Country
     */
    const COUNTRY_T = 25;
    /**
     * Textarea to write YAML syntaxed text
     */
    const YAML_T = 26;
    /**
     * «Many to many» join to a custom doctrine entity class.
     */
    const MANY_TO_MANY_T = 27;
    /**
     * «Many to one» join to a custom doctrine entity class.
     */
    const MANY_TO_ONE_T = 28;
    /**
     * Array field to reference external objects ID (eg. from an API).
     */
    const MULTI_PROVIDER_T = 29;
    /**
     * String field to reference an external object ID (eg. from an API).
     */
    const SINGLE_PROVIDER_T = 30;
    /**
     * Collection field
     */
    const COLLECTION_T = 31;

    /**
     * Associates abstract field type to a readable string.
     *
     * These string will be used as translation key.
     *
     * @var array<string>
     */
    public static $typeToHuman = [
        AbstractField::STRING_T => 'string.type',
        AbstractField::DATETIME_T => 'date-time.type',
        AbstractField::DATE_T => 'date.type',
        AbstractField::TEXT_T => 'text.type',
        AbstractField::MARKDOWN_T => 'markdown.type',
        AbstractField::BOOLEAN_T => 'boolean.type',
        AbstractField::INTEGER_T => 'integer.type',
        AbstractField::DECIMAL_T => 'decimal.type',
        AbstractField::EMAIL_T => 'email.type',
        AbstractField::ENUM_T => 'single-choice.type',
        AbstractField::MULTIPLE_T => 'multiple-choice.type',
        AbstractField::DOCUMENTS_T => 'documents.type',
        AbstractField::NODES_T => 'nodes.type',
        AbstractField::CHILDREN_T => 'children-nodes.type',
        AbstractField::COLOUR_T => 'colour.type',
        AbstractField::GEOTAG_T => 'geographic.coordinates.type',
        AbstractField::CUSTOM_FORMS_T => 'custom-forms.type',
        AbstractField::MULTI_GEOTAG_T => 'multiple.geographic.coordinates.type',
        AbstractField::JSON_T => 'json.type',
        AbstractField::CSS_T => 'css.type',
        AbstractField::COUNTRY_T => 'country.type',
        AbstractField::YAML_T => 'yaml.type',
        AbstractField::MANY_TO_MANY_T => 'many-to-many.type',
        AbstractField::MANY_TO_ONE_T => 'many-to-one.type',
        AbstractField::SINGLE_PROVIDER_T => 'single-provider.type',
        AbstractField::MULTI_PROVIDER_T => 'multiple-provider.type',
        AbstractField::COLLECTION_T => 'collection.type',
    ];
    /**
     * Associates abstract field type to a Doctrine type.
     *
     * @var array<string|null>
     */
    public static $typeToDoctrine = [
        AbstractField::STRING_T => 'string',
        AbstractField::DATETIME_T => 'datetime',
        AbstractField::DATE_T => 'datetime',
        AbstractField::RICHTEXT_T => 'text',
        AbstractField::TEXT_T => 'text',
        AbstractField::MARKDOWN_T => 'text',
        AbstractField::BOOLEAN_T => 'boolean',
        AbstractField::INTEGER_T => 'integer',
        AbstractField::DECIMAL_T => 'decimal',
        AbstractField::EMAIL_T => 'string',
        AbstractField::ENUM_T => 'string',
        AbstractField::MULTIPLE_T => 'simple_array',
        AbstractField::DOCUMENTS_T => null,
        AbstractField::NODES_T => null,
        AbstractField::CHILDREN_T => null,
        AbstractField::COLOUR_T => 'string',
        AbstractField::GEOTAG_T => 'string',
        AbstractField::CUSTOM_FORMS_T => null,
        AbstractField::MULTI_GEOTAG_T => 'text',
        AbstractField::JSON_T => 'text',
        AbstractField::CSS_T => 'text',
        AbstractField::COUNTRY_T => 'string',
        AbstractField::YAML_T => 'text',
        AbstractField::MANY_TO_MANY_T => null,
        AbstractField::MANY_TO_ONE_T => null,
        AbstractField::SINGLE_PROVIDER_T => 'string',
        AbstractField::MULTI_PROVIDER_T => 'simple_array',
        # JSON type is only available since MySQL 5.7 / MariaDB 10.2.7
        AbstractField::COLLECTION_T => 'json',
    ];

    /**
     * List searchable fields types in a searchEngine such as Solr.
     *
     * @var array<int>
     */
    protected static $searchableTypes = [
        AbstractField::STRING_T,
        AbstractField::RICHTEXT_T,
        AbstractField::TEXT_T,
        AbstractField::MARKDOWN_T,
    ];

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     * @Serializer\Groups({"node_type"})
     * @Serializer\Type("string")
     * @var string
     */
    private $name;

    /**
     * AbstractField constructor.
     */
    public function __construct()
    {
        $this->label = 'Untitled field';
        $this->name = 'untitled_field';
    }

    /**
     * @return string $name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = StringHandler::variablize($name ?? '');

        return $this;
    }

    /**
     * @return string Camel case field name
     */
    public function getVarName(): string
    {
        return StringHandler::camelCase($this->getName());
    }

    /**
     * @return string Camel case getter method name
     */
    public function getGetterName(): string
    {
        return StringHandler::camelCase('get ' . $this->getName());
    }

    /**
     * @return string Camel case setter method name
     */
    public function getSetterName(): string
    {
        return StringHandler::camelCase('set ' . $this->getName());
    }

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     * @Serializer\Groups({"node_type"})
     * @Serializer\Type("string")
     * @var string|null
     */
    private $label;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label ?? '';
    }

    /**
     * @param string|null $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label ?? '';

        return $this;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Expose
     * @Serializer\Groups({"node_type"})
     * @Serializer\Type("string")
     * @var string|null
     */
    private $placeholder;

    /**
     * @return mixed
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * @param mixed $placeholder
     * @return AbstractField
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Expose
     * @Serializer\Groups({"node_type"})
     * @Serializer\Type("string")
     * @var string
     */
    private $description;

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description ?? '';

        return $this;
    }
    /**
     * @ORM\Column(name="default_values", type="text", nullable=true)
     * @Serializer\Groups({"node_type"})
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @var string|null
     */
    private $defaultValues;

    /**
     * @return string|null
     */
    public function getDefaultValues(): ?string
    {
        return $this->defaultValues;
    }

    /**
     * @param string|null $defaultValues
     *
     * @return $this
     */
    public function setDefaultValues($defaultValues)
    {
        $this->defaultValues = $defaultValues;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"node_type"})
     * @Serializer\Type("int")
     * @Serializer\Expose
     * @var int
     */
    private $type = AbstractField::STRING_T;

    /**
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        if (!key_exists($this->getType(), static::$typeToHuman)) {
            throw new \InvalidArgumentException($this->getType() . ' cannot be mapped to human label.');
        }
        return static::$typeToHuman[$this->type];
    }

    /**
     * @return string
     */
    public function getDoctrineType(): string
    {
        if (!key_exists($this->getType(), static::$typeToDoctrine)) {
            throw new \InvalidArgumentException($this->getType() . ' cannot be mapped to Doctrine.');
        }
        return static::$typeToDoctrine[$this->getType()];
    }

    /**
     * @param integer $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = (int) $type;

        return $this;
    }

    /**
     * @return bool Is node type field virtual, it's just an association, no doctrine field created
     */
    public function isVirtual(): bool
    {
        return static::$typeToDoctrine[$this->getType()] === null;
    }

    /**
     * @ORM\Column(name="group_name", type="string", nullable=true)
     * @Serializer\Groups({"node_type"})
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @var string|null
     */
    protected $groupName;

    /**
     * @ORM\Column(name="group_name_canonical", type="string", nullable=true)
     * @Serializer\Groups({"node_type"})
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @var string|null
     */
    protected $groupNameCanonical;

    /**
     * Gets the value of groupName.
     *
     * @return string|null
     */
    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    /**
     * @return string|null
     */
    public function getGroupNameCanonical(): ?string
    {
        return $this->groupNameCanonical;
    }

    /**
     * Sets the value of groupName.
     *
     * @param string|null $groupName the group name
     * @return self
     */
    public function setGroupName($groupName)
    {
        $this->groupName = trim(strip_tags($groupName ?? ''));
        $this->groupNameCanonical = StringHandler::slugify($this->getGroupName());
        return $this;
    }

    /**
     * If current field data should be expanded (for choices and country types).
     *
     * @var bool
     * @ORM\Column(name="expanded", type="boolean", nullable=false, options={"default" = false})
     * @Serializer\Groups({"node_type"})
     * @Serializer\Type("bool")
     * @Serializer\Expose
     */
    private $expanded = false;

    /**
     * @return bool
     */
    public function isExpanded(): bool
    {
        return $this->expanded;
    }

    /**
     * @param bool $expanded
     * @return AbstractField
     */
    public function setExpanded($expanded)
    {
        $this->expanded = $expanded;
        return $this;
    }

    /**
     * @return bool
     */
    public function isString(): bool
    {
        return $this->getType() === static::STRING_T;
    }

    /**
     * @return bool
     */
    public function isText(): bool
    {
        return $this->getType() === static::TEXT_T;
    }

    /**
     * @return bool
     */
    public function isDate(): bool
    {
        return $this->getType() === static::DATE_T;
    }

    /**
     * @return bool
     */
    public function isDateTime(): bool
    {
        return $this->getType() === static::DATETIME_T;
    }

    /**
     * @return bool
     */
    public function isRichText(): bool
    {
        return $this->getType() === static::RICHTEXT_T;
    }

    /**
     * @return bool
     */
    public function isMarkdown(): bool
    {
        return $this->getType() === static::MARKDOWN_T;
    }

    /**
     * @return bool
     */
    public function isBoolean(): bool
    {
        return $this->getType() === static::BOOLEAN_T;
    }

    /**
     * @return bool
     */
    public function isBool(): bool
    {
        return $this->isBoolean();
    }

    /**
     * @return bool
     */
    public function isInteger(): bool
    {
        return $this->getType() === static::INTEGER_T;
    }

    /**
     * @return bool
     */
    public function isDecimal(): bool
    {
        return $this->getType() === static::DECIMAL_T;
    }

    /**
     * @return bool
     */
    public function isEmail(): bool
    {
        return $this->getType() === static::EMAIL_T;
    }

    /**
     * @return bool
     */
    public function isDocuments(): bool
    {
        return $this->getType() === static::DOCUMENTS_T;
    }

    /**
     * @return bool
     */
    public function isPassword(): bool
    {
        return $this->getType() === static::PASSWORD_T;
    }

    /**
     * @return bool
     */
    public function isColour(): bool
    {
        return $this->getType() === static::COLOUR_T;
    }

    /**
     * @return bool
     */
    public function isColor(): bool
    {
        return $this->isColour();
    }

    /**
     * @return bool
     */
    public function isGeoTag(): bool
    {
        return $this->getType() === static::GEOTAG_T;
    }

    /**
     * @return bool
     */
    public function isNodes(): bool
    {
        return $this->getType() === static::NODES_T;
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->getType() === static::USER_T;
    }

    /**
     * @return bool
     */
    public function isEnum(): bool
    {
        return $this->getType() === static::ENUM_T;
    }

    /**
     * @return bool
     */
    public function isChildrenNodes(): bool
    {
        return $this->getType() === static::CHILDREN_T;
    }

    /**
     * @return bool
     */
    public function isCustomForms(): bool
    {
        return $this->getType() === static::CUSTOM_FORMS_T;
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->getType() === static::MULTIPLE_T;
    }

    /**
     * @return bool
     */
    public function isMultiGeoTag(): bool
    {
        return $this->getType() === static::MULTI_GEOTAG_T;
    }

    /**
     * @return bool
     */
    public function isJson(): bool
    {
        return $this->getType() === static::JSON_T;
    }

    /**
     * @return bool
     */
    public function isYaml(): bool
    {
        return $this->getType() === static::YAML_T;
    }

    /**
     * @return bool
     */
    public function isCss(): bool
    {
        return $this->getType() === static::CSS_T;
    }

    /**
     * @return bool
     */
    public function isManyToMany(): bool
    {
        return $this->getType() === static::MANY_TO_MANY_T;
    }

    /**
     * @return bool
     */
    public function isManyToOne(): bool
    {
        return $this->getType() === static::MANY_TO_ONE_T;
    }

    /**
     * @return bool
     */
    public function isCountry(): bool
    {
        return $this->getType() === static::COUNTRY_T;
    }

    /**
     * @return bool
     */
    public function isSingleProvider(): bool
    {
        return $this->getType() === static::SINGLE_PROVIDER_T;
    }

    /**
     * @return bool
     */
    public function isMultiProvider(): bool
    {
        return $this->getType() === static::MULTI_PROVIDER_T;
    }

    /**
     * @return bool
     */
    public function isMultipleProvider(): bool
    {
        return $this->isMultiProvider();
    }

    /**
     * @return bool
     */
    public function isCollection(): bool
    {
        return $this->getType() === static::COLLECTION_T;
    }
}
