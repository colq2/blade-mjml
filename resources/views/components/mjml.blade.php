<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    @isset ($title)
        <title>{{ $title }}</title>
    @endisset
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table, td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        p {
            display: block;
            margin: 13px 0;
        }
    </style>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <!--[if lte mso 11]>
    <style type="text/css">
        .mj-outlook-group-fix {
            width: 100% !important;
        }
    </style>
    <![endif]-->

    {!! $buildFontsTags !!}
    {!! $builtMediaQueriesTags !!}
    {!! $buildStyleFromComponents !!}
    {!! $builtStyleFromTags !!}

    {{--    ${buildFontsTags(content, inlineStyle, fonts)}--}}
    {{--    ${buildMediaQueriesTags(breakpoint, mediaQueries, {--}}
    {{--    forceOWADesktop,--}}
    {{--    printerSupport,--}}
    {{--    })}--}}
    {{--    ${buildStyleFromComponents(breakpoint, componentsHeadStyle, headStyle)}--}}
    {{--    ${buildStyleFromTags(breakpoint, style)}--}}
    {{--    ${headRaw.filter(negate(isNil)).join('\n')}--}}
</head>

<body style="{{$bodyStyle}}">
{{-- preview --}}
@if(isset($preview) && !empty($preview))
<div style="display:none;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">
    {{ $preview }}
</div>
@endif
{{ $slot }}
</body>
</html>