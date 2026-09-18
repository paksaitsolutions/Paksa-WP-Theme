Add-Type -AssemblyName System.Drawing

$w = 1200; $h = 900
$bmp = New-Object System.Drawing.Bitmap($w, $h)
$g = [System.Drawing.Graphics]::FromImage($bmp)
$g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
$g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAlias

# Colors
$bgDark  = [System.Drawing.Color]::FromArgb(18, 22, 25)
$navBg   = [System.Drawing.Color]::FromArgb(12, 15, 20)
$cardBg  = [System.Drawing.Color]::FromArgb(22, 28, 36)
$prodBg  = [System.Drawing.Color]::FromArgb(13, 20, 40)
$footBg  = [System.Drawing.Color]::FromArgb(8, 12, 18)
$primary = [System.Drawing.Color]::FromArgb(97, 146, 248)
$purple  = [System.Drawing.Color]::FromArgb(139, 92, 246)
$sky     = [System.Drawing.Color]::FromArgb(14, 165, 233)
$green   = [System.Drawing.Color]::FromArgb(16, 185, 129)
$amber   = [System.Drawing.Color]::FromArgb(245, 158, 11)
$white   = [System.Drawing.Color]::White
$w60     = [System.Drawing.Color]::FromArgb(170, 190, 215)
$w30     = [System.Drawing.Color]::FromArgb(80, 100, 130)
$border  = [System.Drawing.Color]::FromArgb(30, 40, 55)
$eyeBg   = [System.Drawing.Color]::FromArgb(20, 35, 65)
$eyeBdr  = [System.Drawing.Color]::FromArgb(60, 100, 180)
$dot     = [System.Drawing.Color]::FromArgb(22, 97, 146, 248)

# Brushes & Pens
function Brush($c) { New-Object System.Drawing.SolidBrush($c) }
function Pen($c, $w=1) { New-Object System.Drawing.Pen($c, $w) }
function Font($name, $size, $bold=$false) {
    $style = if ($bold) { [System.Drawing.FontStyle]::Bold } else { [System.Drawing.FontStyle]::Regular }
    New-Object System.Drawing.Font($name, $size, $style)
}

# Background
$g.Clear($bgDark)

# Dot grid
$dotBrush = Brush $dot
for ($x = 0; $x -lt $w; $x += 28) {
    for ($y = 0; $y -lt $h; $y += 28) {
        $g.FillEllipse($dotBrush, $x-1, $y-1, 2, 2)
    }
}

# Glow top-right
for ($r = 180; $r -gt 0; $r -= 12) {
    $a = [int](115 - $r * 0.55)
    if ($a -lt 0) { $a = 0 }
    $glowC = [System.Drawing.Color]::FromArgb($a, 97, 146, 248)
    $g.FillEllipse((Brush $glowC), (1100 - $r), (120 - $r), $r*2, $r*2)
}

# Nav bar
$g.FillRectangle((Brush $navBg), 0, 0, $w, 64)
$g.DrawLine((Pen $border), 0, 64, $w, 64)

# Logo pill
$g.FillRectangle((Brush $primary), 32, 16, 96, 32)
$g.DrawString("PAKSA", (Font "Arial" 12 $true), (Brush $white), 40, 22)

# Nav items
$navF = Font "Arial" 10
$nx = 200
foreach ($item in @("Home","Services","Solutions","About","Contact")) {
    $g.DrawString($item, $navF, (Brush $w60), $nx, 22)
    $nx += $item.Length * 7 + 28
}

# CTA button
$g.FillRectangle((Brush $primary), 1042, 18, 140, 28)
$g.DrawString("Get in Touch", (Font "Arial" 9 $true), (Brush $white), 1052, 24)

# Eyebrow pill
$g.FillRectangle((Brush $eyeBg), 60, 90, 380, 30)
$g.DrawRectangle((Pen $eyeBdr), 60, 90, 380, 30)
$g.DrawString("AI / ML  |  Automation  |  Data Science  |  Software", (Font "Arial" 8), (Brush $primary), 70, 98)

# Hero headline
$g.DrawString("Paksa IT Solutions", (Font "Arial" 40 $true), (Brush $white), 60, 135)
$g.DrawString("Enterprise Software & AI for Pakistani Businesses", (Font "Arial" 22 $true), (Brush $primary), 60, 192)
$g.DrawString("AI & Machine Learning  |  Process Automation  |  Data Science  |  Custom Software", (Font "Arial" 11), (Brush $w60), 60, 240)
$g.DrawString("Built in Lahore, Pakistan. Production-ready. In-house team.", (Font "Arial" 11), (Brush $w30), 60, 262)

# CTA buttons
$g.FillRectangle((Brush $primary), 60, 300, 180, 42)
$g.DrawString("Get Started", (Font "Arial" 11 $true), (Brush $white), 80, 312)
$g.DrawRectangle((Pen $w30), 255, 300, 170, 42)
$g.DrawString("Our Services", (Font "Arial" 11), (Brush $w60), 270, 312)

# Stats
$stats = @(@("150+","Projects"),@("8+","Years"),@("50+","ML Models"),@("100%","In-house"))
$sx = 60
foreach ($s in $stats) {
    $g.DrawString($s[0], (Font "Arial" 20 $true), (Brush $white), $sx, 368)
    $g.DrawString($s[1], (Font "Arial" 9), (Brush $w60), $sx, 396)
    $sx += 195
}

# Divider
$g.DrawLine((Pen $border), 0, 425, $w, 425)

# Service cards
$cardColors = @($primary, $purple, $sky, $amber)
$cardLabels = @("AI & ML Solutions","AI Automation","Data Science","Software Dev")
$cardDescs  = @("Predictive models & ML","Workflow automation","BI & analytics","Custom platforms")
$cx = 30
for ($i = 0; $i -lt 4; $i++) {
    $g.FillRectangle((Brush $cardBg), $cx, 440, 265, 165)
    $g.FillRectangle((Brush $cardColors[$i]), $cx, 440, 265, 3)
    $g.DrawString($cardLabels[$i], (Font "Arial" 11 $true), (Brush $white), ($cx+14), 468)
    $g.DrawString($cardDescs[$i], (Font "Arial" 9), (Brush $w60), ($cx+14), 492)
    $g.DrawString("Learn more ->", (Font "Arial" 9), (Brush $cardColors[$i]), ($cx+14), 570)
    $cx += 285
}

# Products section
$g.FillRectangle((Brush $prodBg), 0, 625, $w, 215)
$g.DrawString("OUR PRODUCTS", (Font "Arial" 9 $true), (Brush $primary), 60, 642)
$g.DrawString("Industry-Specific Software Built in Pakistan", (Font "Arial" 18 $true), (Brush $white), 60, 660)

$prodColors = @($primary, $purple, $sky, $amber, $green)
$prodNames  = @("Paksa ERP","EventLogic","TourLedger","PoultryPro","Salon Mgmt")
$px = 60
for ($i = 0; $i -lt 5; $i++) {
    $pw = $prodNames[$i].Length * 9 + 24
    $g.FillRectangle((Brush ([System.Drawing.Color]::FromArgb(20,30,55))), $px, 718, $pw, 36)
    $g.DrawRectangle((Pen $prodColors[$i]), $px, 718, $pw, 36)
    $g.DrawString($prodNames[$i], (Font "Arial" 10), (Brush $white), ($px+10), 728)
    $px += $pw + 16
}

# Footer
$g.FillRectangle((Brush $footBg), 0, 840, $w, 60)
$g.DrawString("paksa.com.pk  |  Lahore, Pakistan  |  info@paksa.com.pk  |  +92 305 777 2572", (Font "Arial" 9), (Brush $w60), 60, 858)
$g.DrawString("Paksa IT Solutions - Enterprise WordPress Theme v1.4.0", (Font "Arial" 9), (Brush $w30), 780, 858)

$g.Dispose()
$bmp.Save("d:\Paksa-WP-Theme\paksa-it-solutions\screenshot.png", [System.Drawing.Imaging.ImageFormat]::Png)
$bmp.Dispose()
Write-Host "screenshot.png saved."
