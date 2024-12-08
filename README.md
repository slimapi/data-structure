# 📚 SlimAPI - Data Structures
[![PHP Version][img-php-version]][link-packagist]
[![Release][img-release]][link-release]
[![License][img-license]][link-license]
[![Build][img-build]][link-build]
[![Code Coverage][img-coverage]][link-coverage]
[![PHPStan][img-phpstan]][link-phpstan]

A collection of reusable and efficient data structures for various use cases.

| Data Structure                 | Status        |
|--------------------------------|---------------|
| Sorted Linked List             | ✅ Implemented |
| Other structures (coming soon) | ⏳ Planned     |

---

## 🔗 SlimAPI\DataStructure\SortedLinkedList
A linked list that **automatically keeps your values sorted**. Supports **integers** or **strings**.

### ✨ Features
- **Automatic Sorting**: Always keeps elements sorted.
- **Customizable Direction**: Sort in ascending (default) or descending order.
- **Duplicate Prevention**: Automatically ensures only unique elements are stored in the list.
- **Operations**: Insert *O(n)*, remove *O(n)*, count *O(1)*, and iterate *O(n)* with ease.

## 📚 Usage Examples

### ✅ Adding Items to the List
Values are inserted while maintaining the sort order.

```php
$list = new SortedLinkedList();
$list->insert(3); // [3]
$list->insert(1); // [1, 3]
$list->insert(2); // [1, 2, 3]
```

### 🔄 Changing Sort Direction
You can control the sorting order by specifying `Direction::ASC` (default) or `Direction::DESC`.

```php
$list = new SortedLinkedList(Direction::DESC);
$list->insert(3); // [3]
$list->insert(1); // [3, 1]
$list->insert(2); // [3, 2, 1]
```

### ❌ Removing Items
Easily remove any value from the list.

```php
$list->remove(2); // [3, 1]
```

### 🔢 Counting and Iterating
The list is both **countable** and **iterable**, perfect for large datasets.

```php
echo $list->count(); // 2

foreach ($list->toGenerator() as $item) {
    echo $item; // Outputs 3, then 1
}
```

---

## 📦 Installation

Add the dependency to your project:
```bash
composer require slimapi/data-structure
```

## 🛠️ Local Development & Testing
Clone the repo, then use the power of `make` to simplify your workflow:

```bash
make help  # See all available commands
make run   # Start the app container
make test  # Run tests and code checkers
```

## 📜 License

This project is licensed under the terms specified in the [LICENSE][link-license] file.

## 🌟 Get Involved

We welcome contributions and suggestions! Please report any issues in the [issue tracker][link-issue-tracker].

[link-build]: https://github.com/slimapi/data-structure/actions
[link-coverage]: https://codecov.io/gh/slimapi/data-structure
[link-issue-tracker]: https://github.com/slimapi/data-structure/issues
[link-license]: LICENSE.md
[link-packagist]: https://packagist.org/packages/slimapi/data-structure
[link-phpstan]: phpstan.neon
[link-release]: https://github.com/slimapi/data-structure/tags

[img-build]: https://img.shields.io/github/actions/workflow/status/slimapi/data-structure/ci.yaml?branch=main&style=flat-square&label=Build
[img-coverage]: https://img.shields.io/codecov/c/github/slimapi/data-structure/main?style=flat-square&label=Coverage
[img-license]: https://img.shields.io/github/license/slimapi/data-structure?style=flat-square&label=License&color=blue
[img-php-version]: https://img.shields.io/packagist/dependency-v/slimapi/data-structure/php?label=PHP&style=flat-square
[img-phpstan]: https://img.shields.io/badge/style-%2010%20%28strict%29-brightgreen.svg?&label=PHPStan&style=flat-square
[img-release]: https://img.shields.io/github/v/tag/slimapi/data-structure.svg?label=Release&style=flat-square
