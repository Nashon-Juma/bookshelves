@extends('layouts.catalog', ['title' => 'Authors'])

@section('content')
    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        @foreach ($authors->chunk(3) as $key => $item)
            <div class="u-row"
                style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                    @foreach ($item as $charKey => $char)
                        <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:500px;"><tr style="background-color: transparent;"><![endif]-->

                        <!--[if (mso)|(IE)]><td align="center" width="167" style="width: 167px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                        <a href="{{ route('features.catalog.authors.character', ['character' => strtolower($charKey)]) }}"
                            class="u-col u-col-33p33"
                            style="max-width: 320px;min-width: 167px;display: table-cell;vertical-align: top;">
                            <div style="width: 100% !important;">
                                <!--[if (!mso)&(!IE)]><!-->
                                <div
                                    style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                    <!--<![endif]-->
                                    <x-catalog.button>
                                        {{ $charKey }}
                                    </x-catalog.button>
                                    <!--[if (!mso)&(!IE)]><!-->
                                </div>
                                <!--<![endif]-->
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
