<?php

namespace Mattmangoni\NovaBlogifyTool\Resources;

use App\Helpers\SubscriptionFrequencyCalculator;
use App\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Image as NovaImage;
use Mattmangoni\NovaBlogifyTool\Fields\ImageUpload;
use Mattmangoni\NovaBlogifyTool\Processors\StoreImage;

class Image extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = 'Mattmangoni\NovaBlogifyTool\Models\Image';

    /**
     * The single value that should be used to represent the resource when being displayed.
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
        'title',
    ];

    /**
     * Hide resource from Nova's standard menu.
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            NovaImage::make('Image')
                ->thumbnail(function () {
                    return Storage::disk(
                        config('nova-blogify.image_settings.disk')
                    )->url($this->filename);
                })
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            ImageUpload::make('Image', 'image', self::class)
                ->store(new StoreImage)
                ->onlyOnForms(),

            Text::make('Title')
                ->sortable()
                ->rules(
                    [
                        'required',
                        'string',
                        'max:255',
                    ]
                )
                ->hideFromIndex()
                ->hideWhenCreating(),

            Text::make('Filename')
                ->sortable()
                ->rules(
                    [
                        'required',
                        'string',
                        'max:255',
                    ]
                )
                ->hideWhenCreating()
                ->hideFromIndex()
                ->hideWhenUpdating(),

            Text::make("URL", function() {
                $url = "https://res.cloudinary.com/de06firjo/image/upload/c_fill,g_auto,w_1000/" . $this->filename;
                return "<a target='_blank' href='$url'>$url</a>";
            })->asHtml(),

            Text::make('Thumbnail')
                ->sortable()
                ->rules(
                    [
                        'required',
                        'string',
                        'max:255',
                    ]
                )
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Text::make('Size')
                ->sortable()
                ->rules(
                    [
                        'required',
                        'string',
                        'max:255',
                    ]
                )
                ->hideWhenCreating()
                ->hideWhenUpdating(),
        ];
    }

    /**
     * Get the cards available for the request.
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
