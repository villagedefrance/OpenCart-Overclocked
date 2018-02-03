<?php
/**
 * @package dompdf
 * @link    http://dompdf.github.com/
 * @author  Benj Carson <benjcarson@digitaljunkies.ca>
 * @author  Helmut Tischer <htischer@weihenstephan.org>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

namespace Dompdf\Positioner;

use Dompdf\FrameDecorator\AbstractFrameDecorator;

/**
 * Positions list bullets
 *
 * @package dompdf
 */
class ListBullet extends AbstractPositioner {

    /**
     * @param AbstractFrameDecorator $frame
     */
    function position(AbstractFrameDecorator $frame) {
        // Bullets & friends are positioned an absolute distance to the left of the content edge of their parent element
        $cb = $frame->get_containing_block();

        // Note: this differs from most frames in that we must position ourselves after determining our width
        $x = $cb["x"] - $frame->get_width();

        $p = $frame->find_block_parent();

        $y = $p->get_current_line_box()->y;

        // This is a bit of a hack...
        $n = $frame->get_next_sibling();

        if ($n) {
            $style = $n->get_style();
            $line_height = $style->length_in_pt($style->line_height, $style->get_font_size());
            $offset = (float)$style->length_in_pt($line_height, $n->get_containing_block("h")) - $frame->get_height();
            $y += $offset / 2;
        }

        // Now the position is the left top of the block which should be marked with the bullet.
        // We tried to find out the y of the start of the first text character within the block.
        // But the top margin/padding does not fit, neither from this nor from the next sibling
        // The "bit of a hack" above does not work also.

        $frame->set_position($x, $y);
    }
}
