<?php

namespace App\Http\Requests\Product;

use App\Commands\Product\CreateProductCommand;
use App\Commands\Product\Data\ProductCategoryData;
use App\Commands\Product\Data\ProductDetailAdditionalInfoData;
use App\Commands\Product\Data\ProductDetailData;
use App\Commands\Product\Data\ProductDetailDimensionData;
use App\Commands\Product\Data\ProductImageData;
use App\Commands\Product\Data\ProductOptionData;
use App\Commands\Product\Data\ProductOptionGroupData;
use App\Commands\Product\Data\ProductPriceData;
use App\Enum\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug|max:255',
            'shortDescription' => 'nullable|string|max:500',
            'fullDescription' => 'nullable|string',
            'sellerId' => 'required|integer|exists:sellers,id',
            'brandId' => 'required|integer|exists:brands,id',
            'status' => ['required', 'string', Rule::enum(ProductStatus::class)],

            'detail' => 'nullable|array',
            'detail.weight' => 'nullable|numeric|min:0',
            'detail.dimensions' => 'nullable|array',
            'detail.dimensions.width' => 'nullable|integer|min:0',
            'detail.dimensions.height' => 'nullable|integer|min:0',
            'detail.dimensions.depth' => 'nullable|integer|min:0',
            'detail.materials' => 'nullable|string',
            'detail.countryOfOrigin' => 'nullable|string|max:100',
            'detail.warrantyInfo' => 'nullable|string',
            'detail.careInstructions' => 'nullable|string',
            'detail.additionalInfo' => 'nullable|array',
            'detail.additionalInfo.assemblyRequired' => 'nullable|boolean',
            'detail.additionalInfo.assemblyTime' => 'nullable|string|max:50',

            'price' => 'required|array',
            'price.basePrice' => 'required|numeric|min:0',
            'price.salePrice' => 'nullable|numeric|min:0',
            'price.costPrice' => 'nullable|numeric|min:0',
            'price.currency' => 'required|string|size:3',
            'price.taxRate' => 'nullable|numeric|min:0|max:100',

            'categories' => 'nullable|array|min:1',
            'categories.*.categoryId' => 'nullable|integer|exists:categories,id',
            'categories.*.isPrimary' => 'nullable|boolean',

            'optionGroups' => 'nullable|array',
            'optionGroups.*.name' => 'required_with:option_groups|string|max:255',
            'optionGroups.*.displayOrder' => 'required_with:option_groups|integer|min:0',
            'optionGroups.*.options' => 'required_with:option_groups|array|min:1',
            'optionGroups.*.options.*.name' => 'required_with:option_groups|string|max:255',
            'optionGroups.*.options.*.additionalPrice' => 'nullable|numeric',
            'optionGroups.*.options.*.sku' => 'nullable|string|max:100|unique:product_options,sku', // SKU 고유성 검사 (상황에 따라 다름)
            'optionGroups.*.options.*.stock' => 'nullable|integer|min:0',
            'optionGroups.*.options.*.displayOrder' => 'nullable|integer|min:0',

            'images' => 'nullable|array',
            'images.*.url' => 'required_with:images|url',
            'images.*.altText' => 'nullable|string|max:255',
            'images.*.isPrimary' => 'nullable|boolean',
            'images.*.displayOrder' => 'nullable|integer|min:0',
            'images.*.optionId' => 'nullable|integer|exists:product_options,id',

            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id', // 실제 태그 테이블과 필드명 확인
        ];

    }

    public function toCreateProductCommand()
    {
        $validated = $this->validated();

        $dimension = isset($validated['detail']['dimensions']) ?
            new ProductDetailDimensionData(
                width: $validated['detail']['dimensions']['width'] ?? null,
                height: $validated['detail']['dimensions']['height'] ?? null,
                depth: $validated['detail']['dimensions']['depth'] ?? null,
            ) : null;

        $additionalInfo = isset($validated['detail']['additionalInfo']) ?
            new ProductDetailAdditionalInfoData(
                assemblyRequired: $validated['detail']['additionalInfo']['assemblyRequired'] ?? null,
                assemblyTime: $validated['detail']['additionalInfo']['assemblyTime'] ?? null,
            ) : null;

        $detail = isset($validated['detail']) ? new ProductDetailData(
            weight: $validated['detail']['weight'] ?? null,
            dimensions: $dimension,
            materials: $validated['detail']['materials'] ?? null,
            countryOfOrigin: $validated['detail']['countryOfOrigin'] ?? null,
            warrantyInfo: $validated['detail']['warrantyInfo'] ?? null,
            careInstructions: $validated['detail']['careInstructions'] ?? null,
            additionalInfo: $additionalInfo,
        ) : null;

        $price = new ProductPriceData(
            basePrice: $validated['price']['basePrice'],
            salePrice: $validated['price']['salePrice'] ?? null,
            costPrice: $validated['price']['costPrice'] ?? null,
            currency: $validated['price']['currency'] ?? 'KRW',
            taxRate: $validated['price']['taxRate'] ?? null,
        );

        $categories = array_map(fn ($category) => new ProductCategoryData(
            categoryId: $category['categoryId'],
            isPrimary: $category['isPrimary'],
        ), $validated['categories'] ?? []);
        
        $optionGroups = array_map(fn ($optionGroup) => new ProductOptionGroupData(
            name: $optionGroup['name'],
            displayOrder: $optionGroup['displayOrder'],
            options: array_map(fn ($option) => new ProductOptionData(
                name: $option['name'],
                additionalPrice: $option['additionalPrice'],
                sku: $option['sku'],
                stock: $option['stock'],
                displayOrder: $option['displayOrder'],
            ), $optionGroup['options'] ?? [])
        ), $validated['optionGroups'] ?? []);

        $images = array_map(fn ($image) => new ProductImageData(
            url: $image['url'],
            altText: $image['altText'] ?? null,
            isPrimary: $image['isPrimary'] ?? null,
            displayOrder: $image['displayOrder'] ?? null,
            optionId: $image['optionId'] ?? null,
        ), $validated['images'] ?? []);

        $tags = $validated['tags'];

        return new CreateProductCommand(
            name: $validated['name'],
            slug: $validated['slug'],
            shortDescription: $validated['shortDescription'] ?? null,
            fullDescription: $validated['fullDescription'] ?? null,
            sellerId: $validated['sellerId'],
            brandId: $validated['brandId'],
            status: $validated['status'],
            details: $detail,
            price: $price,
            categories: $categories,
            optionGroups: $optionGroups,
            images: $images,
            tags: $tags,
        );
    }
}
